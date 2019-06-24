<?php

namespace App\Form;

use App\Entity\Contract;
use App\Entity\Grower;
use App\Form\ProductType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContractType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description', TextareaType::class, [
                'required' => false,
                'help' => 'La description du contrat sera affiché sur la page du contrat.'
            ])
            ->add('summary', TextareaType::class, [
                'help' => 'Le résumé du contrat sera affiché sur la page d\'accueil et sur la page listant les contrats.'
            ])
            ->add('starting_season_at', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('ending_season_at', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('image_file', FileType::class, [
                'required' => false
            ])
            ->add('products', CollectionType::class, [
                'entry_type' => ProductType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('grower', EntityType::class, [
                'class' => Grower::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'empty_data' => false,
                'help' => 'Pensez à créer le producteur avant de pouvoir l\'assigner à un contrat. Attention, un producteur ne peut appartenir qu\'à un seul contrat.'
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