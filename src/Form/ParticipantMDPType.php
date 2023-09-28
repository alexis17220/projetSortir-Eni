<?php

namespace App\Form;

use App\Entity\Participant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipantMDPType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

           $builder
               ->add('password', RepeatedType::class, [
                   'type' => PasswordType::class,
                   'invalid_message' => 'Le mot de passe ne correspond pas.',
                   'options' => ['attr' => ['class' => 'password-field']],
                   'required' => true,
                   'first_options' => ['label' => 'Mot de Passe'],
                   'second_options' => ['label' => 'Confirmation de mot de passe'],
               ]);

    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}