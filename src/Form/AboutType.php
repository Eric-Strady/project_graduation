<?php

namespace App\Form;

use App\Entity\About;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AboutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description')
            ->add('how_join_us')
            ->add('amap_gps_lat')
            ->add('amap_gps_lng')
            ->add('nb_members')
            ->add('annual_membership_fee')
            ->add('facebook_link')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => About::class,
            'translation_domain' => 'forms'
        ]);
    }
}
