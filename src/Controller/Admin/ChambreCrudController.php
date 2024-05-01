<?php

namespace App\Controller\Admin;

use App\Entity\Images;
use App\Entity\Chambre;
use App\Form\ImagesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;

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
            MoneyField::new('prix')->setCurrency('EUR'),
            CollectionField::new('images')->setEntryType(ImagesType::class)->onlyOnForms(),
            BooleanField::new('statut')->setLabel('Publié'),
            
        ];
    }
    
   

    
}