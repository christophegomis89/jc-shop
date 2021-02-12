<?php 

 namespace App\Form;
 
 use App\Classe\Search;
use App\Entity\Categorie;
use Symfony\Component\Form\FormBuilderInterface;
 use Symfony\Component\OptionsResolver\OptionsResolver;
 use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SearchType extends AbstractType
 {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('string', TextType::class, [
            'label'=>'Rechercher',
            'required'=>false,
            'attr'=>[
                'placeholder'=>'Rechercher...',
                'class'=>'form-control-sm'
            ]
        ])
        ->add('categories',EntityType::class, [
            'label'=> false,
            'required'=>false,
            'class'=> Categorie::class,
            'multiple'=> true,
            'expanded'=>true
        ])
        ->add('submit', SubmitType::class, [
            'label'=>'filtre',
            'attr'=>[
                'class'=>'btn-block btn-info'
            ]
        ])
        ;


    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method'=> 'GET',
            'cscrf_protection'=>false
        ]);
    }
    public function getBlockPrefix()
    {
        return '';
    }
 }

?>