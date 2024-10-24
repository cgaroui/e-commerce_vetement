<?php

namespace App\Repository;

use App\Entity\Produit;
use App\Model\SearchData;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Produit>
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    public function findProduitsEnSolde()
    {
        // Requete DQL pour récupérer les produits en solde(ayant une réduction)
        return $this->createQueryBuilder('p')
            ->where('p.reduction IS NOT NULL')
            ->andWhere('p.reduction > 0')
            ->getQuery()
            ->getResult();
    }


    public function findProduitsParCategorie($categoryId)
    {

        //requete DQL pour récuperer les produits par leur categorie 
        return $this->createQueryBuilder('p')
        ->join('p.categorie', 'c')
        ->where('c.id = :categoryId')
        ->setParameter('categoryId', $categoryId)
        ->getQuery()
        ->getResult();
    }

    public function findProduitsNouveaux($limit = 12)
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.dateCreation', 'DESC') //du plus récent au moins récent
            ->setMaxResults($limit) // pour choisir le nombre de produit limit à afficher 
            ->getQuery()
            ->getResult();
    }

    //produits par recherche 
    public function findBySearch(SearchData $searchData)
    {
        $qb = $this->createQueryBuilder('p');

        if (!empty($searchData->q)) {
            // Recherche mot clé dans les noms ou descriptions des produits
            //l'expression orX() permet de rechercher dans plusieurs colonnes ici nom et description
            $qb->andWhere($qb->expr()->orX(
                $qb->expr()->like('p.nom', ':q'),
                $qb->expr()->like('p.description', ':q')
            ))
            ->setParameter('q', '%' . $searchData->q . '%');
        }

        return $qb; // Retourne le QueryBuilder (pas un tableau de résultats)
    }

}
