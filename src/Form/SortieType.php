<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\Ville;

use App\Repository\LieuRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,[
                'label'=>'Nom de la sortie :',
                'required'=>true,
                'attr'=>[
                    'class'=> 'form-control col-md-8',
                ],
            ])
            ->add('dateHeureDebut',DateTimeType::class,[
                'label'=>'Date et heure de la sortie :',
                'widget' => 'single_text',
                'html5' => false,
                'format'=>'yyyy-MM-dd HH:mm',
                'required'=>true,
                'attr'=>[
                    'class'=> 'form-control',
                ],
            ])

            ->add('dateLimiteInscription',DateType::class,[
               'label'=>'Date limite d inscription :',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
               'required'=>true,
                'attr'=>[
                    'class'=> 'form-control',
                ],
           ])
            ->add('nbInscriptionMax',IntegerType::class,[
                'label'=>'Nombre de place :',
                'required'=>true,
                'attr'=>[
                    'class'=> 'form-control col-md-8',
                ],
            ])
            ->add('duree',IntegerType::class,[
                'label'=>'Durée :',
                'required'=>true,
                'attr'=>[
                    'class'=> 'form-control col-md-8',
                ],
            ])
            ->add('description',TextareaType::class,[
                'label'=>'Description et infos :',
                'required'=>true,
                'attr'=>[
                    'class'=> 'form-control col-md-8',
                ],
            ])
            ->add('organisateur',EntityType::class,[
                'class'=>Site::class,
                'choice_label'=>'nom',
                'label'=>'Ville organisatrice :',
                'required'=>true,
                'attr'=>[
                    'class'=> 'form-control',
                ],
            ])
            ->add('ville',EntityType::class,[
                'mapped' => false,
                'class'=>Ville::class,
                'choice_label'=>'nom',
                'label'=>'Ville :',
                'required'=>true,
                'attr'=>[
                    'class'=> 'form-control',
                ],
                ])

            ->add('lieu',EntityType::class,[

                'class'=>Lieu::class,
                'choice_label' => 'nom',
                'label'=>'Lieu :',
                'required'=>true,
                'attr'=>[
                    'class'=> 'form-control',
                ],
            ])
            ->add('rue',EntityType::class,[
                'mapped' => false,
                'class'=>Lieu::class,
                'choice_label' => 'rue',
                'label'=>'Rue :',
                'required'=>true,
                'attr'=>[
                    'class'=> 'form-control',
                ],
            ])
            ->add('codePostal',EntityType::class,[
                'mapped' => false,
                'class'=>Ville::class,
                'choice_label' => 'codePostal',
                'label'=>'Code postal :',
                'required'=>true,
                'attr'=>[
                    'class'=> 'form-control',
                ],
            ])
            ->add('latitude',EntityType::class,[
                'mapped' => false,
                'class'=>Lieu::class,
                'choice_label' => 'latitude',
                'label'=>'latitude :',
                'required'=>true,
                'attr'=>[
                    'class'=> 'form-control',
                ],
            ])
            ->add('Longitude',EntityType::class,[
                'mapped' => false,
                'class'=>Lieu::class,
                'choice_label' => 'longitude',
                'label'=>'Longitude :',
                'required'=>true,
                'attr'=>[
                    'class'=> 'form-control',
                ],
            ])

            //->add('SiteOrga')
           // ->add('participants')
           // ->add('etat')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
