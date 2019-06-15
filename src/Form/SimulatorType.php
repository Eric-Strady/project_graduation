<?php

namespace App\Form;

use App\Entity\FoodType;
use App\Simulator\Simulator;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SimulatorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nb_adult', NumberType::class, [
                'required' => true,
                'attr' => ['autofocus' => 'true']
            ])
            ->add('nb_child', NumberType::class, [
                'required' => true
            ])
            ->add('food_type', EntityType::class, [
                'class' => FoodType::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'empty_data' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Simulator::class,
        ]);
    }
}
