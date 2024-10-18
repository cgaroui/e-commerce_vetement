<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Produit;
use App\Entity\Categorie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProduitsFixtures extends Fixture
{
    // public function getDependencies()
    // {
    //     return [
    //         CategorieFixtures::class, //pour s'assurer que les catégories sont chargées avant les produits
    //     ];
    // }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create(); // Initialisation de faker pour générer des données

        // Récupérer toutes les catégories existantes
        $categorieRepository = $manager->getRepository(Categorie::class);
        $categories = $categorieRepository->findAll(); // Récupérer toutes les catégories

        if (empty($categories)) {
            throw new \Exception('Aucune catégorie trouvée dans la base de données.');
        }

        // Pour créer 20 produits fictifs
        for ($i = 0; $i < 20; $i++) {
            $produit = new Produit();
            $produit->setNom($faker->word);  // Générer un nom de produit aléatoire
            $produit->setReference($faker->bothify('REF-####'));  // Générer une référence aléatoire
            $produit->setPrix($faker->numberBetween(1, 300));  // Générer un prix
            $produit->setDescription($faker->sentence(10));  // Générer une description
            $produit->setImage($faker->imageUrl(100, 100, 'technics'));  // Générer une image
            $produit->setReduction($faker->numberBetween(0, 30));  // Générer une réduction
            
            // Assigner une catégorie aléatoire parmi celles existantes
            $produit->setCategorie($faker->randomElement($categories)); // Choisir une catégorie aléatoire

            $manager->persist($produit);  // Persister l'entité Produit
        }

        $manager->flush();  // Enregistrer les données en base
    }
    
    

       
    
}