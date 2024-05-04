<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Text;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ServiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Service::class;
    }
    public function configureCrud(Crud $crud):Crud
    {
        return $crud 
        ->showEntityActionsInlined();
    }
        
    
    public function configureFields(string $pageName): iterable
    {
        return [
            
            TextField::new('nomService')->setLabel('Services'),
            TextareaField::new('description')->setLabel('Description'),
            ChoiceField::new('icone')->setChoices([
                'Hotel' => 'fas fa-hotel',
                'Restaurant' => 'fas fa-utensils',
                'Salle de sport' => 'fas fa-dumbbell',
                'Spa' => 'fas fa-spa',
                'Wifi' => 'fas fa-wifi',
                'Parking' => 'fas fa-parking',
                'television' => 'fas fa-tv',
                'sport' => 'fas fa-swimmer',
                'Climatiseur' => 'fas fa-snowflake',
                'Chauffage d\'ambiance' => 'fas fa-temperature-high',
                'Chauffage eau' => 'fas fa-hot-tub'
                            
                
            
                // Ajoutez d'autres icônes ici selon votre besoin
            ]),
            
            
        ];
    }
    
}