<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;


use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('date_debut', DateTimeType::class,[
                'widget'=> 'single_text'
            ])
            ->add('duree' )
            ->add('date_cloture', DateType::class,[
                'widget'=> 'single_text',

            ])
            ->add('nb_inscription_max')
            ->add('description_info')
            ->add('ville', EntityType::class,[
                    'class' => 'App\Entity\Ville',
                    'choice_label'=>function($ville){
                    return $ville->getNomVille();
                },
                    'placeholder' => 'Selectionner une ville',
                    'required' => false ,
                    'mapped' => false
            ]
            )
        ;



        $builder->get('ville')->addEventListener(

            FormEvents::POST_SUBMIT,

            function (FormEvent $event){

                $form = $event->getForm();

                $this->addLieuField($form->getParent(), $form->getData());

            }

        );

        $builder->addEventListener(

            FormEvents::POST_SET_DATA,

            function (FormEvent $event){

                $data = $event->getData();

                /* @var $lieu Lieu */

                $lieu = $data->getLieu();

                $form = $event->getForm();

                if($lieu){

                    $ville = $lieu->getVille();

                    $this->addLieuField($form, $ville);

                    $form->get('ville')->setData($ville);

                }else{

                    $this->addLieuField($form, null);

                }



            }
        );



    }

    //lieu
    private function addLieuField(FormInterface $form, ?Ville $ville){

        $builder = $form->add('lieu', EntityType::class,[

            'class' => Lieu::class,

            'choice_label'=>function($lieu){
                return $lieu->getNomLieu();
            },
            'placeholder' => $ville ? 'Selectionnez votre lieu' : 'Selectionnez votre ville',

            'required' => true,

            'auto_initialize' => false,

            'choices' => $ville ? $ville->getLieu() : []

        ]);
    }



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,

        ]);
    }
}
