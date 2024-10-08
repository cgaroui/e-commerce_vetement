<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProduitController extends AbstractController
{
    #[Route('/produits', name: 'app_produit')]
    public function index(ProduitRepository $repository, Request $request, PaginatorInterface $paginator): Response
    {
        $produits = $paginator->paginate( 
        $repository->findAll(),
        $request->query->getInt('page', 1), /*numero de page*/
        9 /*limit par page*/
            );

        return $this->render('produit/index.html.twig', [
            'produits' => $produits
        ]);
    }

    #[Route('/produit/nouveau', name: 'nouveau_produit')]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
       
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Persist le produit 
            $manager->persist($produit);
            // Enregistre les données dans la base de données
            $manager->flush();

            // Message de succès
            $this->addFlash('success', 'Votre produit a bien été ajouté avec succès!');

            // Redirection vers la liste des produits ou une autre page
            return $this->redirectToRoute('app_produit');
        }

        return $this->render('produit/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    
    #[Route('/produit/edit/{id}', name: 'edit_produit')]
    public function edit(Request $request, EntityManagerInterface $manager, $id)
    {
        // Récupération du produit par son ID
        $produit = $manager->getRepository(Produit::class)->find($id);

        // Si le produit n'existe pas, on lève une erreur 404
        if (!$produit) {
            throw new NotFoundHttpException('Produit non trouvé');
        }

        // Création du formulaire avec les données du produit récupéré
        $form = $this->createForm(ProduitType::class, $produit);

        // Gestion de la soumission du formulaire
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Pas besoin de persist car l'entité existe déjà
            $manager->flush();

            // Ajouter un message de succès
            $this->addFlash('success', 'Le produit a bien été modifié.');

            // Redirection vers la liste des produits
            return $this->redirectToRoute('app_produit');
        }

        // Affichage du formulaire d'édition
        return $this->render('produit/edit.html.twig', [
            'form' => $form->createView() ,
            'produit' => $produit
            ]);
    }    
           
        
   


    #[Route('/produit/supprimer/{id}', name: 'supprimer_produit')]
    public function delete(Request $request, EntityManagerInterface $manager, $id)
    {
        // Récupération du produit par son ID
        $produit = $manager->getRepository(Produit::class)->find($id);

        // Si le produit n'existe pas, on lève une erreur 404
        if (!$produit) {
            throw new NotFoundHttpException('Produit non trouvé');
        }

        // Vérifier le token CSRF pour la sécurité (facultatif mais recommandé)
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            // Suppression du produit
            $manager->remove($produit);
            $manager->flush();

            // Message flash pour confirmer la suppression
            $this->addFlash('success', 'Le produit a bien été supprimé.');
        } else {
            $this->addFlash('error', 'Échec de la suppression, token CSRF invalide.');
        }

        // Redirection après la suppression (vers la liste des produits par exemple)
        return $this->redirectToRoute('app_produit');
    }


    //methode pour récuperer la liste des produits ayant une remise 
    #[Route('/produits/soldes', name: 'produits_soldes')]
    public function produitsSoldes(ProduitRepository $produitRepository): Response
    {
        // Récupérer les produits en solde via la méthode du repository
        $produitsEnSolde = $produitRepository->findProduitsEnSolde();

        return $this->render('produit/soldes.html.twig', [
            'produits' => $produitsEnSolde,
        ]);
    }

    //methode pour acceder au detail du produit 
    #[Route('/produit/detail/{id}', name: 'produit_detail')]
    public function detail(int $id, EntityManagerInterface $manager)
    {
        //récupérer le produit grace à son id 
        $produit = $manager->getRepository(Produit::class)->find($id);

        //je veriifie si le produit existe
        if(!$produit){
            throw new NotFoundHttpException('Produit non trouvé');
        }

        //sinon je renvoie vers la vue du detail produit 
        return $this->render('produit/detail.html.twig', [
            'produit' => $produit,
        ]);
    }

}
