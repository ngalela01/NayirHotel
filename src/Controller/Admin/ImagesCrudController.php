<?php

namespace App\Controller\Admin;

use App\Entity\Images;
use App\Form\ImagesType;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Form\Type\VichFileType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;

class ImagesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Images::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->showEntityActionsInlined()
        
        ;
        
    }
   
           
    
   
    
    public function configureFields(string $pageName): iterable
    
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('chambre'),
            ImageField::new('nomImage')->setLabel('Image')->setBasePath('/asset/uploads/images')
                                        ->setUploadDir('/public/asset//uploads/images/')
                                        ->onlyOnIndex(),
            TextareaField::new('imageFile')
                ->setLabel('Votre image')
                ->setFormType(VichImageType::class)
                ->onlyOnForms()
                ->setFormTypeOption('allow_delete', false),
                
                
                
                
                
      
                
        ];
    }

}