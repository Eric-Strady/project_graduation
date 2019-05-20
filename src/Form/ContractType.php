<?php

namespace App\Form;

use App\Entity\Contract;
use App\Form\ProductType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
            ->add('image_file', FileType::class, [
                'required' => false
            ])
            ->add('products', CollectionType::class, [
                'entry_type' => ProductType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true
            ])
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