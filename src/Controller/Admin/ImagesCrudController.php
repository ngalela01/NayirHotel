<?php

namespace App\Controller\Admin;

use App\Entity\Images;
use App\Form\ImagesType;
use Symfony\Component\Security\Core\Role\Role;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ImagesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Images::class;
    }

    // public function configureCrud(Crud $crud): Crud
    // {
    //     return $crud
    //     ->showEntityActionsInlined();
    // }
    
   
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            ImageField::new('nomImage')->onlyOnIndex()->setBasePath('/uploads/images/'),
            AssociationField::new('chambre'),
            TextareaField::new('imageFile')
            ->setFormType(VichImageType::class) // Utiliser VichImageType pour le champ imageFile
            ->onlyOnForms(),
            
                
        ];
    }

}