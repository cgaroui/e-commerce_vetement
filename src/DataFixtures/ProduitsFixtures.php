<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Produit;
use App\Entity\Categorie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProduitsFixtures extends Fixture
{
    public function getDependencies()
    {
        return [
            CategorieFixtures::class, //pour s'assurer que les catégories sont chargées avant les produits
        ];
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create(); // initialisation de faker pour générer des données
        
        // Récupérer la catégorie avec l'ID 1
        $categorieRepository = $manager->getRepository(Categorie::class);
        $categorie = $categorieRepository->find(3);
        
        if (!$categorie) {
            throw new \Exception('La catégorie avec ID 1 n\'existe pas.');
        }
    
        // création de 20 produits fictifs
        for ($i = 0; $i < 20; $i++) {
            $produit = new Produit();
            $produit->setNom($faker->word);  // générer un nom de produit aléatoire
            $produit->setReference($faker->bothify('REF-####'));  // générer une référence aléatoire
            $produit->setPrix($faker->numberBetween(1, 300));  // générer un prix
            $produit->setDescription($faker->sentence(10));  // générer une description
            $produit->setImage($faker->imageUrl(100, 100, 'technics'));  // générer une image
            $produit->setReduction($faker->numberBetween(0, 30));  // générer une réduction
            
            // Assigner la catégorie ayant l'ID 1
            $produit->setCategorie($categorie);
    
            $manager->persist($produit);  // Persister l'entité Produit
        }
    
        $manager->flush();  // Enregistrer les données en base
    }
    

       
    
}
