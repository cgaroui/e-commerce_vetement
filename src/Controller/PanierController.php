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
            // if ($produit->getReduction() != null){
            //     $total = 
            // }
            $total+= $produit->getPrix() * $quantite;
            
        }
        
        return $this->render('panier/index.html.twig',
         [
            // 'produit' => $produit,
            // 'quantite' => $quantite,
            'data' => $data,
            'total' => $total
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

    #[Route('/panier/retirerProduit/{id}', name: 'retirer_du_panier')]
    public function retirerDuPanier(Produit $produit,SessionInterface $session )
    {
        //on recupere l'id du produit 
        $id = $produit->getId();

        //on recupere le panier existant , s'il existe pas dans ma session je met le tableau vide d'ou les []
        $panier = $session->get('panier', []);

        //on retire le produit du panier s'il n'y a qu'un seul  
        //sinon on décremente la quantitée
        //on verifie d'abord si le panier n'est pas vide 
        if(!empty($panier[$id])){
            if ($panier[$id] > 1) {

                  $panier[$id]--;//si le produit est present + d'une fois on decremente 
            }else{
                unset($panier[$id]);// sinon on l'enleve (unset pour defaire la variable)
            }
            
        }
        $session->set('panier', $panier);
      //on redirige vers le panier 
      return $this->redirectToRoute('app_panier');

    }

    #[Route('/panier/supprimer/{id}', name: 'supprimer_du_panier')]
    public function supprimerProduit(Produit $produit,SessionInterface $session )
    {
        //on recupere l'id du produit 
        $id = $produit->getId();

        //on recupere le panier existant 
        $panier = $session->get('panier', []);

        //on verifie d'abord si le panier n'est pas vide 
        if(!empty($panier[$id])){
            unset($panier[$id]); //on  supprime le produit 
        }
        $session->set('panier', $panier);
      //on redirige vers le panier 
      return $this->redirectToRoute('app_panier');

    }

    #[Route('/panier/vider', name: 'vider_panier')]
    public function viderPanier(SessionInterface $session )
    {
        
        $session->remove('panier');

        //on redirige vers le panier 
      return $this->redirectToRoute('app_panier');
        
    }
}