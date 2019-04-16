<?php

namespace App\Form;

use App\Entity\Contract;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContractType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('grower_name')
            ->add('summary')
            ->add('starting_season_at', null, [
                'widget' => 'single_text'
            ])
            ->add('ending_season_at', null, [
                'widget' => 'single_text'
            ])
            ->add('grower_gps_lat')
            ->add('grower_gps_lng')
            ->add('image', ImageType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contract::class,
            'translation_domain' => 'forms'
        ]);
    }
}