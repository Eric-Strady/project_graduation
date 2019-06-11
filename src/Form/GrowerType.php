<?php

namespace App\Form;

use App\Entity\Grower;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GrowerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('address')
            ->add('city')
            ->add('postal_code')
            ->add('gps_lat')
            ->add('gps_lng')
            ->add('email')
            ->add('website')
            ->add('phone')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Grower::class,
            'translation_domain' => 'forms'
        ]);
    }
}
