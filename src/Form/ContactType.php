<?php

namespace App\Form;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom',TextType::class,[
                'label'=>'Prenom',
                'attr'=>[
                    'placeholder'=>'Veuillez saisir votre prénom'
                ]
            ])
            ->add('nom',TextType::class,[
                'label'=>'Nom',
                'attr'=>[
                    'placeholder'=>'Veuillez saisir votre nom'
                ]
            ])
            ->add('email',EmailType::class,[
                'label'=>'Email',
                'attr'=>[
                    'placeholder'=>'Veuillez saisir votre email'
                ]
            ])
            ->add('content',TextareaType::class,[
                'label'=>'Message',
                'attr'=>[
                    'placeholder'=>'Veuillez saisir votre message'
                ]
            ])
            ->add('submit',SubmitType::class,[
                'label'=>'envoyer',
                'attr'=>[
                    'class'=>'btn btn-success btn-block'
                ]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
