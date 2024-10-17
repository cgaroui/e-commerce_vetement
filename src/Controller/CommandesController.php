<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class CommandesController extends AbstractController
{
    #[Route('/commande/ajout', name: 'ajout_commande')]
    public function ajoutCommande(SessionInterface $session): Response
    {
        //mettre condition pour que l'utilisateur doit etre absolument connecté sinon il ne peux pas passer commande 
        $this->denyAccessUnlessGranted('ROLE_USER');
        $panier  =  $session->get('Panier',[]);
        // $user = $session->getUser();
        dd($panier);
        return $this->render('commandes/index.html.twig', [
            'controller_name' => 'CommandesController',
        ]);
    }
}
