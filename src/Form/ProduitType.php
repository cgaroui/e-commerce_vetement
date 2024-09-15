<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
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
                'mapped' => false, // Comme tu stockeras probablement seulement le nom du fichier dans la base de données
                'required' => false,
                'constraints' => [
                    new Assert\Image([
                        'maxSize' => '2M',
                        'mimeTypesMessage' => 'Veuillez uploader une image valide (JPG, PNG, etc.).'
                    ])
                ]
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
                ]
            ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
