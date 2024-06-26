<?php

namespace App\Form;

use App\Entity\Chambre;
use App\Entity\TypeDeChambre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints as Assert; // Importation de l'espace de noms Assert

class ChambreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
        ->add('dateArrivee')
        ->add('dateDepart')
        ->add('nombreAdultes', IntegerType::class, [
            'constraints' => [
                new Assert\Positive(),
            ],
            'attr' => [
                'min' => 0, // Définit la valeur minimale
            ],
            
        ])
        
        ->add('nombreEnfants', IntegerType::class, [
            'constraints' => [
                new Assert\Positive(),
            ],
            'attr' => [
                'min' => 0, 
            ],
            
        ]);
        
        

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chambre::class,
        ]);
    }
}