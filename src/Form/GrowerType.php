<?php

namespace App\Form;

use App\Entity\Grower;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GrowerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'help' => 'Le nom renseigné ici servira également de description pour le marqueur de la carte.'
            ])
            ->add('address')
            ->add('city')
            ->add('postal_code')
            ->add('gps_lat', null, [
                'help' => 'Exemple de latitude: 48.862725'
            ])
            ->add('gps_lng', null, [
                'help' => 'Exemple de longitude: 2.287592'
            ])
            ->add('email', EmailType::class, [
                'required' => false
            ])
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
