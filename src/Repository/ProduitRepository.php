<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
}
