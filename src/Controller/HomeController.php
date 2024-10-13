<?php
namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(ProduitRepository $repository, Request $request, PaginatorInterface $paginator): Response
    {
        // Récupérer la liste des nouveaux produits
        $produitsQuery = $repository->findProduitsNouveaux();

        // Pagination des produits
        $produits = $paginator->paginate(
            $produitsQuery, // Query des produits
            $request->query->getInt('page', 1), // Récupérer le numéro de la page actuelle (par défaut 1)
            3 // Limite d'éléments par page
        );

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'produits' => $produits,
        ]);
    }
}
