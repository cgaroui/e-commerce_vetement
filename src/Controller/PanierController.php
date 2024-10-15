<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(SessionInterface $session, ProduitRepository $ProduitRepository)
    {
        $panier = $session->get('panier', []);

        //initialisation des variables 
        $data = [];
        $total = 0; 

       
        // $session->set('panier',[]); // pour supprimer le panier car j'avais un produit inexistant 

        //on parcourt le paniser sous forme clé valeur de chque produit par son id et sa quantité 
        foreach($panier as $id => $quantite){
            $produit = $ProduitRepository->find($id);
            $data[] = [
                'produit' =>$produit,
                'quantite' => $quantite
            ];
            $total+= $produit->getPrix() * $quantite;
            
        }
            // dd($totalCommande);
        return $this->render('panier/index.html.twig',
         [
            'produit' => $produit,
            'quantite' => $quantite,
            'data' => $data
        ]);
    }

    #[Route('/panier/ajout/{id}', name: 'ajout_panier')]
    public function ajoutAuPanier(Produit $produit,SessionInterface $session )
    {
        //on recupere l'id du produit 
        $id = $produit->getId();

        //on recupere le panier existant , s'il existe pas dans ma session je met le tableau vide d'ou les []
        $panier = $session->get('panier', []);

        //on ajoute le produit dans le panier s'il n'yest pas encore 
        //sinon j'incrémente la quantitée
        if(empty($panier[$id])){
             $panier[$id] = 1;
        }else{
            $panier[$id]++;
        }
        $session->set('panier', $panier);
      //on redirige vers lepanier 
      return $this->redirectToRoute('app_panier');

    
     
    }
}
