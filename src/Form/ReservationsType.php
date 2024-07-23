<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Chambre;
use App\Entity\Reservations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('dateArrive', null, [
                'widget' => 'single_text',
            ])
            ->add('dateDepart', null, [
                'widget' => 'single_text',
            ])
            
            ->add('capaciteAdulte')
            ->add('capaciteEnfant')
            ->add('email')
            // ->add('chambre', EntityType::class, [
            //     'class' => Chambre::class,
            //     'choice_label' => 'numero',
            // ]);
            
            
            
        ;
    }

    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
        ]);
    }
}