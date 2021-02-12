<?php

namespace App\Form;

use App\Entity\Adresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
        ->add('nomAdresse', TextType::class, [
            'label'=>' Quel nom souhaitez- vous donner à votre adresse?',
            'attr'=>[
                'placeholder'=>'Veuillez renseigner le nom de votre adresse'
            ]
        ])
            ->add('nom', TextType::class, [
                'label'=>' Nom',
                'attr'=>[
                    'placeholder'=>'Veuillez renseigner votre nom'
                ]
            ])
            ->add('prenom', TextType::class, [
                'label'=>' Prenom',
                'attr'=>[
                    'placeholder'=>'Veuillez renseigner votre prenom'
                ]
            ])
            ->add('entreprise', TextType::class, [
                'label'=>'Entreprise',
                'attr'=>[
                    'placeholder'=>'Veuillez renseigner votre entreprise(facultatif'
                ]
            ])
            ->add('adresse', TextType::class, [
                'label'=>' Adresse',
                'attr'=>[
                    'placeholder'=>'Veuillez renseigner votre adresse de livraison'
                ]
            ])
            ->add('codePostal', TextType::class, [
                'label'=>' Code postal',
                'attr'=>[
                    'placeholder'=>'Exple 94500 '
                ]
            ])
            ->add('ville', TextType::class, [
                'label'=>'Ville ',
                'attr'=>[
                    'placeholder'=>'Veuillez renseigner votre ville de residence'
                ]
            ])
            ->add('pays', CountryType::class, [
                'label'=>' Pays',
                'attr'=>[
                    'placeholder'=>'Veuillez renseigner votre pays '
                ]
            ])
            ->add('telephone', TelType::class, [
                'label'=>' Téléphone',
                'attr'=>[
                    'placeholder'=>'Veuillez renseigner votre numéro de téléphone'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label'=>'Valider',
                'attr'=>[
                    'class'=>'btn-block btn-info'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adresse::class,
        ]);
    }
}
