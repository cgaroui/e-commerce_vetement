<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Produit;
use App\Entity\Commande;
use Stripe\Checkout\Session;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\CarteService;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaimentController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em ,UrlGeneratorInterface $generator)
    {
        $this->em = $em;
        $this->generator =$generator;
    }


    #[Route('/commande/create-session-stripe/{refCommande}', name: 'paiment_stripe')]
    public function stripeChekout ($refCommande): RedirectResponse
    {

        $produitStripe = [];

       // Recherche de la commande par sa référence
        $commande = $this->em->getRepository(Commande::class)->findOneBy(['refCommande' => $refCommande]);

        //si la commande n'existe pas je redirige vers le panier
        if(!$commande){
            $this->redirectToRoute('app_panier');
        }

        //je parcours la commande pour vérifier que chaque produit est bien récupéré
        foreach ($commande->getDetailCommandes()->getValues() as $produit) {

            // onrecupere l'entité du produit correspondant à partir de la base de données pui le produit est identifié à partie de son id 
            $produitData = $this->em->getRepository(Produit::class)->findOneBy(['id' => $produit->getProduit()->getId()]);
        

             // Préparer les données Stripe pour chaque produit dans le format attendu
            $produitStripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $produitData->getPrix(), 
                    'product_data' => [
                        'name' => $produitData->getNom(), 
                    ]
                ],
                'quantity' => $produit->getQuantite(),
            ];
        }  
        // dd($produitStripe);

  //----------------------------------------------------------------------------------
        // gerer le cas de la livraison 

  //----------------------------------------------------------------------------------

  Stripe::setApiKey(apiKey: 'sk_test_51QBFioIzYM3DZnexzgfxkfGVezLqemFWRPID48sCe9T2dss1IPPt0SsPFZonsJjXkBkMshaD5knUMw6rAedVSYWQ00iA1NBen5');
        
        
        $checkout_session = Session::create([
            // Initialiser l'email à Stripe avec le customer_email
            'customer_email' => $this->getUser()->getEmail(),
            'payment_method_types' => ['card'], // Correction de 'payement_method_types' à 'payment_method_types'
            'line_items' => [
                $produitStripe
            ],
            'mode' => 'payment',
            'success_url' => $this->generator->generate('paiment_success', [
                'refCommande' => $commande->getRefCommande()
            ], UrlGeneratorInterface::ABSOLUTE_URL), // Correction ici

            'cancel_url' => $this->generator->generate('paiment_error', [
                'refCommande' => $commande->getRefCommande() // Ajout de la virgule manquante
            ], UrlGeneratorInterface::ABSOLUTE_URL), // Correction ici
        ]);


        return new RedirectResponse($checkout_session->url);
    }


    
    #[Route('/commande/success/{refCommande}', name: 'paiment_success')]
    public function stripeSuccess ($refCommande , CarteService $service): Response
    {
        return $this->render('commande/success.html.twig');
    }

    #[Route('/commande/success/{refCommande}', name: 'paiment_error')]
    public function stripeError ($refCommande , CarteService $service): Response
    {
        return $this->render('commande/error.html.twig');
    }
}
