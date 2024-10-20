<?php 

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Produit;
use App\Entity\Commande;
use Stripe\Checkout\Session;
use App\Entity\DetailCommande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaimentController extends AbstractController
{
    private EntityManagerInterface $em;
    private UrlGeneratorInterface $generator;

    public function __construct(EntityManagerInterface $em, UrlGeneratorInterface $generator)
    {
        $this->em = $em;
        $this->generator = $generator;
    }

    #[Route('/commande/create-session-stripe/{refCommande}', name: 'paiment_stripe')]
    public function stripeChekout($refCommande): RedirectResponse
    {
        $produitStripe = [];

        // Recherche de la commande par sa référence
        $commande = $this->em->getRepository(Commande::class)->findOneBy(['refCommande' => $refCommande]);

        // Si la commande n'existe pas, redirige vers le panier
        if (!$commande) {
            return $this->redirectToRoute('app_panier');
        }

        // Parcours des détails de la commande pour préparer les données Stripe
        foreach ($commande->getDetailCommandes()->getValues() as $produit) {
            $produitData = $this->em->getRepository(Produit::class)->findOneBy(['id' => $produit->getProduit()->getId()]);

            // Préparer les données Stripe pour chaque produit
            $produitStripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $produitData->getPrix() * 100, // Convertir en centimes
                    'product_data' => [
                        'name' => $produitData->getNom(),
                    ]
                ],
                'quantity' => $produit->getQuantite(),
            ];
        }

        // Initialiser Stripe
        Stripe::setApiKey('sk_test_51QBFioIzYM3DZnexzgfxkfGVezLqemFWRPID48sCe9T2dss1IPPt0SsPFZonsJjXkBkMshaD5knUMw6rAedVSYWQ00iA1NBen5');

        // Création de la session de paiement Stripe
        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getEmail(),
            'payment_method_types' => ['card'],
            'line_items' => $produitStripe,
            'mode' => 'payment',
            'success_url' => $this->generator->generate('paiment_success', [
                'refCommande' => $commande->getRefCommande()
            ], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generator->generate('paiment_error', [
                'refCommande' => $commande->getRefCommande()
            ], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        // dd($checkout_session); // Pour déboguer la session de paiement

        return new RedirectResponse($checkout_session->url);
    }

    #[Route('/commande/success/{refCommande}', name: 'paiment_success')]
    public function stripeSuccess($refCommande, SessionInterface $session): Response
    {
        // Récupérer les informations de la commande depuis la session
        // $commandeData = $session->get('commande'); // Assurez-vous d'avoir stocké la commande
        // dd($commandeData); // Pour déboguer les données de la commande

        // Exemple de données de commande à utiliser pour le test
        $commandeData = [
            'nom' => 'Dupont',
            'prenom' => 'Jean',
            'panier' => [
                1 => 2, // Id du produit => Quantité
                2 => 1,
            ]
        ];

        if ($commandeData) {
            // créer une nouvelle commande
            $commande = new Commande();
            
            // d'associer l'utilisateur
            $commande->setUser($this->getUser());
            $commande->setDateCommande(new \DateTime());
            $commande->setNomUser($commandeData['nom']);
            $commande->setPrenomUser($commandeData['prenom']);
            $prixTotal = 0;

            foreach ($commandeData['panier'] as $idProduit => $quantite) {
                $produit = $this->em->getRepository(Produit::class)->find($idProduit);

                if ($produit) {
                    $detailCommande = new DetailCommande();
                    $detailCommande->setProduit($produit);
                    $detailCommande->setQuantite($quantite);
                    $detailCommande->setCommande($commande);

                    $commande->addDetailCommande($detailCommande);
                    $prixTotal += $produit->getPrix() * $quantite;
                }
            }

            // Mettre à jour le prix total et sauvegarder la commande
            $commande->setPrixTotal($prixTotal);
            $this->em->persist($commande);
            $this->em->flush();

            // Retirer les informations de commande de la session
            $session->remove('commande');

            return $this->render('commandes/success.html.twig', [
                'refCommande' => $refCommande,
            ]);
        }

        return $this->redirectToRoute('confirmation_commande'); // Rediriger si pas de commande trouvée
    }

    #[Route('/commande/error/{refCommande}', name: 'paiment_error')]
    public function stripeError($refCommande): Response
    {
        return $this->render('commandes/error.html.twig', [
            'refCommande' => $refCommande,
        ]);
    }
}
