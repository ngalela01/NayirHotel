<?php

namespace App\Controller\Admin;

use App\Entity\Chambre;
use App\Entity\Service;
use App\Form\ImagesType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ChambreCrudController extends AbstractCrudController
{  
    private $adminUrlGenerator;
    private $entityManager;

    public function __construct(AdminUrlGenerator $adminUrlGenerator, EntityManagerInterface $entityManager)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->entityManager = $entityManager;
    }
    public static function getEntityFqcn(): string
    {
        return Chambre::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()  
            ->setEntityLabelInSingular('Chambre')
            ->setEntityLabelInPlural('Chambres');
    }


    
    
    

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            IntegerField::new('numero'),
            AssociationField::new('typeDeChambre'),
            IntegerField::new('CapaciteAdulte'),
            IntegerField::new('CapaciteEnfant'),
            IntegerField::new('lits'),
            IntegerField::new('sallesDeBain'),
            MoneyField::new('prix')->setCurrency('EUR'),
            CollectionField::new('images')->setEntryType(ImagesType::class)->onlyOnForms(),
            BooleanField::new('statut')->setLabel('Publié'),
            AssociationField::new('services')
            ->setFormTypeOptions([
                'multiple' => true, // Permet la sélection multiple de services
                'by_reference' => false, // Gère correctement les relations ManyToMany
                
                
            ])
            
            
                            
                
            
        ];
    }
    
    
   


    
}