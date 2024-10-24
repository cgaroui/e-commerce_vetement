<?php
namespace App\Controller;

use App\Form\SearchType;
use App\Model\SearchData;
use App\Repository\ProduitRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProduitRepository $repository, Request $request, PaginatorInterface $paginator): Response
    {
        // Création de l'objet de recherche et du formulaire
        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);
    
        // Définition de la page actuelle
        $searchData->page = $request->query->getInt('page', 1);
    
        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Recherche des produits filtrés par la recherche
            $query = $repository->findBySearch($searchData); // Retourne un QueryBuilder ou une Query
    
            // Pagination des résultats de recherche
            $produits = $paginator->paginate(
                $query,
                $searchData->page,
                9 // Nombre d'éléments par page
            );
    
            return $this->render('produit/index.html.twig', [
                'form' => $form->createView(),
                'produits' => $produits, // Produits paginés
            ]);
        }
    
        // Produits par défaut si aucune recherche n'est soumise
        $produits = $paginator->paginate(
            $repository->findAll(), // Requête pour tous les produits 
            $searchData->page,
            9 // Nombre d'éléments par page
        );
    
        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'produits' => $produits, // Produits paginés par défaut
        ]);
    }
}
