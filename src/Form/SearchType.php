<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints as Assert; // Importation de l'espace de noms Assert


class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
         ->add('dateArrivee')
         ->add('dateDepart')
        ->add('capaciteAdulte', IntegerType::class, [
            'required' => false, // Définir le champ comme facultatif
            'constraints' => [
                new Assert\Positive(),
            ],
            'attr' => [
                'min' => 0, // Définit la valeur minimale
            ],
            
        ])
        
        ->add('capaciteEnfant', IntegerType::class, [
            'required' => false, // Définir le champ comme facultatif
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
            'data_class' => SearchData::class,
        ]);
    }
}