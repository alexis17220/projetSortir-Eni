<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('rue')
            ->add('latitude')
            ->add('longitude')
//            ->add('Ville', EntityType::class, [
//                'class' => 'App\Entity\Ville',
//                'choice_label' => function ($ville) {
//                    return $ville->getNomVille();
//                },
//                'placeholder' => "Sélectionner une ville"
//            ])
//
//            ->add('code_postal', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
        ]);
    }
}
