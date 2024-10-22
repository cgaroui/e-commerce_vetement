<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Champ prix avec validation
            ->add('prix', NumberType::class, [
                'label' => 'Prix',
                'html5' => true, // Active la validation HTML5 pour tester les décimales
                'attr' => [
                    'step' => '0.01',
                    'min' => 0,
                ],
                'constraints' => [
                    new Assert\Positive([
                        'message' => 'Le prix doit être positif.'
                    ]),
                    new Assert\LessThan([
                        'value' => 200,
                        'message' => 'Le prix doit être inférieur à 200 €.'
                    ])
                ]
            ])
            
            // Champ nom avec des contraintes de longueur et d'existence obligatoire
            ->add('nom', TextType::class, [
                'label' => 'Nom du produit',
                'constraints' => [
                    new Assert\Length(['min' => 2]),
                    new Assert\NotBlank([
                        'message' => 'Le nom du produit est obligatoire'
                    ])
                ]
            ])
            
            // Champ description (non obligatoire, mais contrainte si rempli)
            ->add('description', TextType::class, [
                'label' => 'Description',
                'required' => false, // Facultatif
            ])
            
            // Champ image, gestion du fichier
            ->add('imageFile', FileType::class, [
                'label' => 'Image du produit',
                'required' => false,
                'constraints' => [
                    new Assert\Image([
                        'mimeTypesMessage' => 'Veuillez uploader une image valide (JPG, PNG, etc.).'
                    ])
                ],
                'data_class' => null, // Pour permettre l'upload de fichiers
            ])
            
            // Champ réduction optionnel avec contrainte de validité
            ->add('reduction', IntegerType::class, [
                'label' => 'Réduction (%)',
                'required' => false,
                'constraints' => [
                    new Assert\Positive([
                        'message' => 'La réduction doit être positive.'
                    ]),
                    new Assert\LessThanOrEqual([
                        'value' => 100,
                        'message' => 'La réduction ne peut pas dépasser 100%.'
                    ])
                ]
            ])
            
            // Champ catégorie sous forme de sélection
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom', // Le champ 'nom' de l'entité Categorie est affiché
                'label' => 'Catégorie',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);  
    }
}