<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Produit;
use App\Entity\Commentaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
         // Champ pour le texte du commentaire
         ->add('texte', TextareaType::class, [
            'label' => 'Commentaire',
            'attr' => [
                'placeholder' => 'Écrivez votre commentaire ici...',
                'rows' => 5,
            ],
        ])

        // Champ pour la photo liée au produit (upload d'une image)
        ->add('photoProduit', FileType::class, [
            'label' => 'Joindre une photo (optionnel)',
            'required' => false,
            'attr' => [
                'accept' => 'image/*',
            ],
        ])

        // Champ pour la note du produit (un champ numérique pour la note que je transeformerais en étoiles )
        ->add('noteProduit', IntegerType::class, [
            'label' => 'Note du produit',
            'attr' => [
                'min' => 1,
                'max' => 5,
                'step' => 1,
                'placeholder' => 'Attribuez une note de 1 à 5',
            ],
        ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}
