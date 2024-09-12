<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{
    #[Route('/produit', name: 'app_produit')]
    public function index(ProduitRepository $repository, Request $request, PaginatorInterface $paginator): Response
    {
        $produits = $paginator->paginate( 
        $repository->findAll(),
        $request->query->getInt('page', 1), /*page number*/
        9 /*limit par page*/
            );

        return $this->render('produit/index.html.twig', [
            'produits' => $produits
        ]);
    }
}
