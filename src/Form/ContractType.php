<?php

namespace App\Form;

use App\Entity\Contract;
use App\Form\ProductType;
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
            ->add('grower_name', TextType::class, [
                'help' => 'Le nom renseigné ici servira également de description pour le marqueur de la carte.'
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
            ->add('grower_gps_lat', null, [
                'help' => 'Exemple de latitude: 48.862725'
            ])
            ->add('grower_gps_lng', null, [
                'help' => 'Exemple de longitude: 2.287592'
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