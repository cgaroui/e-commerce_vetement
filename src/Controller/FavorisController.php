<?php

namespace App\Controller;

use App\Entity\Favoris;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FavorisController extends AbstractController
{

    #[Route('/favoris', name: 'liste_favoris')]
    public function listeFavoris(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login'); // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
        }
    
        $favoris = $entityManager->getRepository(Favoris::class)->findBy(['user' => $user]);
    
        return $this->render('favoris/index.html.twig', [
            'favoris' => $favoris,
        ]);
    }
    

    #[Route('/favoris/{produitId}', name: 'ajout_favoris')]
    public function addFavoris(int $produitId, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login'); // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
        }
    
        // Trouver le produit par son ID
        $produit = $entityManager->getRepository(Produit::class)->find($produitId);
        if (!$produit) {
            throw $this->createNotFoundException('Produit non trouvé');
        }
    
        // Vérifier si le produit est déjà dans les favoris de l'utilisateur
        $dejaFavoris = $entityManager->getRepository(Favoris::class)
            ->findOneBy(['user' => $user, 'produit' => $produit]);
    
        if ($dejaFavoris) {
            $this->addFlash('warning', 'Ce produit est déjà dans vos favoris.');
            return $this->redirectToRoute('liste_favoris'); // Redirige vers la liste des favoris
        }
    
        // Créer un nouvel objet Favoris
        $favori = new Favoris();
        $favori->setUser($user);
        $favori->setProduit($produit);
    
        // Persister l'entité Favoris
        $entityManager->persist($favori);
        $entityManager->flush();
    
        $this->addFlash('success', 'Le produit a été ajouté à vos favoris.');
    
        return $this->redirectToRoute('liste_favoris'); // Redirige vers la liste des favoris
    }


    #[Route('/favoris/supprimer/{id}', name: 'supprimer_favoris')]
    public function removeFavoris(int $id, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login'); // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
        }

        // Trouver l'objet Favoris par son ID
        $favoris = $entityManager->getRepository(Favoris::class)->find($id);
        if (!$favoris || $favoris->getUser() !== $user) {
            throw $this->createNotFoundException('Favoris non trouvé ');
        }

        // Supprimer l'entité Favoris
        $entityManager->remove($favoris);
        $entityManager->flush();

        $this->addFlash('success', 'Le produit a été retiré de vos favoris.');

        return $this->redirectToRoute('liste_favoris'); // Redirige vers la liste des favoris
    }

}