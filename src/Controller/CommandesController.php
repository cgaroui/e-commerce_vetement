<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Commande;
use App\Entity\DetailCommande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandesController extends AbstractController
{
    #[Route('/commande/ajout', name: 'ajout_commande')]
    public function ajoutCommande(SessionInterface $session, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $panier = $session->get('panier', []);
        // dd($panier); -> recuperation panier ok 

        // Vérifier si le panier est vide
        if (empty($panier)) {
            $this->addFlash('message', 'Votre panier est vide.');
            return $this->redirectToRoute('app_panier');
        }

        // Créer une nouvelle commande
        $commande = new Commande();
        $user = $this->getUser();
        // dd($user);  recuperation user connecté ok 
        $commande->setUser($user); // Associer l'utilisateur connecté
        $commande->setDateCommande(new \DateTime());

        // donner le nom et le prénom de l'utilisateur à la commande
        if ($user) {
            $nom = $user->getNom();
            $prenom = $user->getPrenom();
        
            // dd($nom, $prenom);  //ça affiche bien les infos 
            
            $commande->setNomUser($nom);
            $commande->setPrenomUser($prenom);
        
        } else {
            throw new \Exception("L'utilisateur doit être connecté pour passer une commande.");
        }

        $prixTotal = 0;

        // parcourir le panier et créer le détails de la commande (les articles dans le panier )
        foreach ($panier as $idProduit => $quantite) {
            //on recupere le produit par son id 
            $produit = $entityManager->getRepository(Produit::class)->find($idProduit);

            if ($produit) {
                $detailCommande = new DetailCommande();
                $detailCommande->setProduit($produit);
                $detailCommande->setQuantite($quantite);
                $detailCommande->setCommande($commande);

                $commande->addDetailCommande($detailCommande);
                $prixTotal += $produit->getPrix() * $quantite; 
        }

        //mettre à jour le prix total et sauvegarder la commande en bdd
        $commande->setPrixTotal($prixTotal);
        $entityManager->persist($commande);
        $entityManager->flush();

        // Retirer le panier de la session après la commande
        $session->remove('panier');

       // redirection vers la page de confirmation avec l'ID de la commande
        return $this->redirectToRoute('confirmation_commande', [
        'id' => $commande->getId(),
        'refCommande' => $commande->getRefCommande()
        ]);
    
        }
    }
    


    #[Route('/commande/confirmation/{id}', name: 'confirmation_commande')]
    public function confirmationCommande(Commande $commande): Response
    {
        // pour qu'elle passe la commande récup à la vue Twig
        return $this->render('commandes/confirmation.html.twig', [
            'commande' => $commande,
            'refCommande' => $commande->getRefCommande()
         
        ]);
    }
}
