<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProfileController extends AbstractController
{
    private Security $security; // Déclaration de la propriété

    public function __construct(Security $security) // Injection de dépendance
    {
        $this->security = $security; // Initialisation de la propriété
    }
    #[Route('/mon-compte', name: 'app_profile')]
    public function profile(): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->security->getUser();

        // Vérifier si l'utilisateur est authentifié
        if (!$user) {
            return $this->redirectToRoute('app_login'); // Rediriger vers la page de connexion si non authentifié
        }

        return $this->render('profile/profile.html.twig', [
            'user' => $user,
        ]);
    }


    #[Route('/mon-compte/modifier', name: 'app_profile_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->security->getUser();

        // Vérifier si l'utilisateur est authentifié
        if (!$user) {
            return $this->redirectToRoute('app_login'); // Rediriger vers la page de connexion si non authentifié
        }

        // Créer le formulaire pour modifier les informations de l'utilisateur
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer les modifications dans la base de données
            $entityManager->persist($user);
            $entityManager->flush();

            // Ajouter un message flash pour indiquer que les informations ont été mises à jour
            $this->addFlash('success', 'Vos informations ont été mises à jour avec succès.');

            return $this->redirectToRoute('app_profile'); // Rediriger vers la page "Mon Compte"
        }

        return $this->render('profile/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
