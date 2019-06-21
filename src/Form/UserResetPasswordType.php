<?php

namespace App\Form;

use App\Security\ResetPasswordForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('old_password', PasswordType::class, [
                'always_empty' => true,
                'required' => true
            ])
            ->add('new_password', PasswordType::class, [
                'required' => true,
                'help' => 'Le mot de passe doit contenir au minimum 8 caractères, un chiffre et une lettre, une majuscule et un caractère spécial.',
            ])
            ->add('new_confirm_password', PasswordType::class, [
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ResetPasswordForm::class,
            'translation_domain' => 'forms'
        ]);
    }
}
