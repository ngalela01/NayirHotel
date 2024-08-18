<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Chambre;
use App\Entity\Reservations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ReservationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('dateArrive', DateType::class, [
                'widget' => 'single_text',
                'html5' => false, // Désactive HTML5
                'format' => 'dd-MM-yyyy', // Format attendu par Symfony
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\GreaterThanOrEqual([
                        'value' => (new \DateTime())->format('d-m-Y'),
                        'message' => 'La date d\'arrivée ne peut pas être antérieure à aujourd\'hui.',
                    ]),
                ],
                'label' => false,
            ])
            ->add('dateDepart', DateType::class, [
                'widget' => 'single_text',
                'html5' => false, // Désactive HTML5
                'format' => 'dd-MM-yyyy', // Format attendu par Symfony
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\GreaterThanOrEqual([
                        'value' => (new \DateTime())->format('d-m-Y'),
                        'message' => 'La date de départ ne peut pas être antérieure à aujourd\'hui.',
                    ]),
                ],
                'label' => false,
            ])
            
            ->add('capaciteAdulte', IntegerType::class, [
                'constraints' => [
                    new Assert\PositiveOrZero(), // Autorise zéro
                ],
                'attr' => [
                    'min' => 0, // Définit la valeur minimale
                ],
                
            ]) 
            
            ->add('capaciteEnfant', IntegerType::class, [
                'constraints' => [
                    new Assert\PositiveOrZero(), // Autorise zéro
                ],
                'attr' => [
                    'min' => 0, 
                ],
                
            ])
            ->add('email')
            ->add('demandeSpeciale', TextareaType::class, [
                'required' => false,
            
            ]);
            
            
            
        ;
    }

    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
        ]);
    }
}