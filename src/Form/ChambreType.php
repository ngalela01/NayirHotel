<?php

namespace App\Form;

use App\Entity\Chambre;
use App\Entity\TypeDeChambre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChambreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero')
            ->add('capaciteAdulte')
            ->add('capaciteEnfant')
            ->add('statut')
            ->add('prix')
            ->add('typeDeChambre', EntityType::class, [
                'class' => TypeDeChambre::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chambre::class,
        ]);
    }
}
