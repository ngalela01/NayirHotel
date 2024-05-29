<?php

namespace App\Controller\Admin;

use App\Entity\Commentaire;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CommentaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commentaire::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud 
        ->showEntityActionsInlined() ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
        ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
            return $action->displayIf(function () {
                // Vérifiez si l'utilisateur connecté a le rôle ROLE_SUPER_ADMIN
                return $this->isGranted('ROLE_SUPER_ADMIN');
            });
        });
    }
   
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnDetail(),
            AssociationField::new('user')->setLabel('nom')
            ->setLabel('Utilisateur')
                ->formatValue(function ($value, $entity) {
                    $user = $entity->getUser();
                    return $user ? $user->getName() . ' ' . $user->getPrenom() : '';
                }),
            TextField::new('contenu'),
            IntegerField::new('note'),
            DateField::new('date')
        ];
    }
    
}