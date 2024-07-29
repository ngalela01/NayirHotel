<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()  
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs')
            
        ;
    }

        public function configureActions(Actions $actions): Actions
    {
        return $actions
        ->disable(Action::NEW); 
        
        
    }
        
    
    public function configureFields(string $pageName): iterable
    {       
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name')->setLabel('Nom'),
            TextField::new('prenom')->setLabel('Prénom'),
            EmailField::new('email'),
            TextField::new('password')->setLabel('Mot de passe')->onlyOnForms(),
            ArrayField::new('roles'),
            DateField::new('createdAt')->onlyOnForms(),
            DateTimeField::new('updatedAt')->hideOnForm()
            
            
        ];
    }
   // methode qui donne la date de creation
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {   
        if (!$entityInstance instanceof User) return;
        $entityInstance->setCreatedAt(new \DateTimeImmutable());
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

    // methode qui donne la date de modification
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {   if ($entityInstance instanceof User){
        $entityInstance->setUpdatedAt(new \DateTimeImmutable());
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
    }
   
    
    
}