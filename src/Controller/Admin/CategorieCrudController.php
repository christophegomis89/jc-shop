<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class CategorieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categorie::class;
    }

    
    // public function configureFields(string $pageName): iterable
    // {
    //     return [
            
    //         TextField::new('Title'),
    //         TextareaField::new('Description'),
    //         MoneyField::new('Prix')->setCurrency('EUR')
    //     ];
    // }
    
}
