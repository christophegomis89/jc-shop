<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('prenom',TextType::class,[
                'disabled'=>true,
                'label'=>'Mon prenom'
            ])
            ->add('nom',TextType::class,[
                'disabled'=>true,
                'label'=>'Mon nom'
            ])
            ->add('email',EmailType::class,[
                'disabled'=>true,
                'label'=>'Mon email'
            ])

            ->add('old_password',PasswordType::class,[
                'label'=>'Mon mot de passe actuel',
                'mapped'=>false,
                'attr'=>[
                    'placeholder'=>'Veuillez renseigner votre mot de passe actuel',
                ]
                
            ])

            ->add('new_password',RepeatedType::class, [

                'type'=>PasswordType::class,
    
                'invalid_message'=>'le mot de passe et la confirmation doivent être identiques!',
                'mapped'=>false,
    
                'label'=>'Votre mot de passe',
                
                'required'=>true,
    
                'first_options'=>['label'=>'Modifier mon mot de passe',
    
                'attr'=>[
                    'placeholder'=>'Veuillez modifier votre mot de passe'
                ]
                
                ],
    
                'second_options'=>['label'=>'Confirmer votre mot de passe',
                'attr'=>[
                    'placeholder'=>'Veuillez confirmer votre nouveau mot de passe'
                ]
                
                ]
                            
            ])
            ->add('submit',SubmitType::class,[
                'label'=>'Mettre à jour'
            ])

           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
