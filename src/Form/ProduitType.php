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
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Champ prix avec validation
            ->add('prix', MoneyType::class, [
                'label' => 'Prix',
                'currency' => 'EUR', // Par défaut en euros
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
                'attr' => [
                    'minlength' => 2
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2]),
                    new Assert\NotBlank([
                        'message' => 'Le nom du produit est obligatoire'
                    ])
                ]
            ])
            
            // Champ description obligatoire pour preciser les note de tete de fond du parfum ou composition autres produits 
            ->add('description', TextType::class, [
                'label' => 'Description',
                'required' => false,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'La description est obligatoire.'
                    ])
                ]
            ])
            
            // Champ image, gestion du fichier (non mappé à l'entité)
            ->add('image', FileType::class, [
                'label' => 'Image du produit',
                'required' => false,
                'constraints' => [
                    new Assert\Image([
                        'mimeTypesMessage' => 'Veuillez uploader une image valide (JPG, PNG, etc.).'
                    ])
                    ],
                'data_class' => null,
            ])
            
            // Champ réduction optionnel avec une contrainte pour s'assurer qu'il est positif et raisonnable
            ->add('reduction', IntegerType::class, [
                'label' => 'Réduction (%)',
                'required' => false,
                'constraints' => [
                    new Assert\Positive([
                        'message' => 'Le prix doit être positif.'
                    ]),
                    new Assert\LessThanOrEqual([
                        'value' => 100,
                        'message' => 'La réduction ne peut pas dépasser 100%.'
                    ])
                    ],
                    'data_class' => null,
            ])
                
                    
                    // Nouveau champ de catégories sous forme de selecteur
                    ->add('nom', TextType::class)
                    ->add('prix', IntegerType::class)
                    ->add('categorie', EntityType::class, [
                        'class' => Categorie::class,
                        'choice_label' => 'nom', // Supposons que 'nom' est un champ de votre entité Categorie
                    ]);
            }
        
            public function configureOptions(OptionsResolver $resolver): void
            {
                $resolver->setDefaults([
                    'data_class' => Produit::class,
                ]);  
            }
        }