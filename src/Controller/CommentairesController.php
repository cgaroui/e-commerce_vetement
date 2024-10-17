<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentairesController extends AbstractController
{
    #[Route('/produit/{id}/commentaire', name: 'ajout_commentaire')]
    public function ajouterCommentaire(Produit $produit, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Vérifier si l'utilisateur est connecté
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        // Créer une nouvelle instance de Commentaire
        $commentaire = new Commentaire();
        $commentaire->setProduit($produit);  // pour associer le produit au commentaire
        $commentaire->setUser($user);        // et associer l'utilisateur au commentaire

         // Ici on initialise la date du commentaire à la date actuelle
         $commentaire->setDate(new \DateTime());

        // on Crée le formulaire
        $form = $this->createForm(CommentaireType::class, $commentaire);

        // Traitement de la requête
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persister le commentaire en base de données
            $entityManager->persist($commentaire);
            $entityManager->flush();

            // Ajouter un message de succès
            $this->addFlash('success', 'Votre commentaire a été ajouté.');

            // Rediriger vers la page du produit
            return $this->redirectToRoute('produit_detail', ['id' => $produit->getId()]);
        }

        // Rendre la vue avec le formulaire
        return $this->render('commentaire/ajout.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }
}
