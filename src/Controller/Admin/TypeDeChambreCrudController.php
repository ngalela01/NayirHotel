<?php

namespace App\Controller\Admin;

use App\Entity\TypeDeChambre;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TypeDeChambreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TypeDeChambre::class;
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()  
            ->setEntityLabelInSingular('Type De Chambre')
            ->setEntityLabelInPlural('Types De Chambres');
            
        
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('nom'),
            TextareaField::new('description')->onlyOnForms(),
            BooleanField::new('statut')
                ->setLabel('Publié')

                
        ];
    }
    
}