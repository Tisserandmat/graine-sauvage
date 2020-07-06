<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom *',
                'attr' => [
                    'placeholder' => 'Benoit'
                ]
            ])

            ->add('lastname', TextType::class, [
                'label' => 'Nom *',
                'attr' => [
                    'placeholder' => 'Dupont'
                ]
            ])

            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'benoit.dupont@gmail.com'
                ]
            ])

            ->add('login', TextType::class, [
                'label' => 'Identifiant *',
            'attr' => [
        'placeholder' => 'Dupont45'
                ]])

            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'invalid_message' => 'Les champs de mot de passe doivent correspondre.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => [
                    'label' => 'Mot de passe *',
                    'attr' => [
                    'placeholder' => 'Saisissez votre mot de passe'
                    ]
                ],
                'second_options' => ['label' => 'Mot de passe  *',
                    'attr' => [
                        'placeholder' => 'Confirmer votre mot de passe'
                    ]
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
