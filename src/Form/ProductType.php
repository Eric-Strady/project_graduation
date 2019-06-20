<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\FoodType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('is_variable_delivery', ChoiceType::class, [
                'label' => 'Le client peut-il choisir ses livraisons?',
                'choices' => [
                    'Non' => false,
                    'Oui' => true
                ]
            ])
            ->add('nb_delivery', NumberType::class)
            ->add('is_fixed_price', ChoiceType::class, [
                'label' => '',
                'choices' => [
                    'Non' => false,
                    'Oui' => true
                ]
            ])
            ->add('fixed_price', MoneyType::class, [
                'required' => false
            ])
            ->add('min_price', MoneyType::class, [
                'required' => false
            ])
            ->add('max_price', MoneyType::class, [
                'required' => false
            ])
            ->add('food_types', EntityType::class, [
                'class' => FoodType::class,
                'choice_label' => 'name',
                'label_attr' => [
                    'class' => 'foodTypes'
                ],
                'multiple' => true,
                'expanded' => false,
                'empty_data' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
