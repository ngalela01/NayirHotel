<?php

namespace App\Controller\Admin;

use App\Entity\Reservations;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ReservationsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservations::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->onlyOnIndex(), // Afficher uniquement dans la liste

            AssociationField::new('chambre')
                ->setLabel('Chambre')
                ->setFormTypeOption('choice_label', 'typeDeChambre.nom'), // Adapté si vous avez une relation avec une entité Chambre

            DateField::new('dateArrive')
                ->setLabel('Date d\'arrivée'),

            DateField::new('dateDepart')
                ->setLabel('Date de départ'),

            TextEditorField::new('demandeSpeciale')
                ->setLabel('Demande spéciale'),

            BooleanField::new('confirmation')
                ->setLabel('Confirmation'),

                AssociationField::new('user')
                ->setLabel('Utilisateur')
                ->setFormTypeOptions([
                    'choice_label' => function ($user) {
                        return $user->getName() . ' ' . $user->getPrenom();
                    }
                ]),
        ];
    }
}