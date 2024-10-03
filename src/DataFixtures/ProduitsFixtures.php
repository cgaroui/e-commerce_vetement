<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Produit;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProduitsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create(); //initialisation de faker pour générer des données

        //création de 20 produits fictifs
        for ($i=0; $i < 20 ; $i++) { 
            $produit = new Produit();
            $produit->setNom($faker->word); //pour générer un nom de produit alétoire 
            $produit->setReference($faker->word); //pour générer un nom de produit alétoire 
            $produit->setReference($faker->bothify('REF-####'));  // Générer une référence aléatoire
            $produit->setPrix($faker->numberBetween(1, 300));  // Générer un prix entre 1 et 100 euros
            $produit->setDescription($faker->sentence(10));  // Générer une description
            $produit->setImage($faker->imageUrl(100, 100, 'technics'));  // Générer une image
            $produit->setReduction($faker->numberBetween(0, 30));  // Génerer une reduction


            
            $manager->persist($produit);  // Persister l'entité Produit
        }

        $manager->flush();  // Enregistrer les données en base
    }
       
    
}
