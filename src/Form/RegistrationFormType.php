<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

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
                'first_options' => [
                    'label' => 'Mot de passe *',
                    'help' => 'Votre mot de passe doit contenir 8 caractères minimum avec 1 majuscule,
                1 minuscule, 1 chiffre et 1 caractère spécial',
                    'attr' => [
                        'placeholder' => '#Motdepasse01'
                    ]
                ],
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                    new Regex([
                        'pattern' => "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,})$/m",
                        'message' => "Votre mot de passe doit contenir 1 majuscule, 1 minuscule,
                        1 chiffre et un caractère spécial "
                    ])
                ],
                'second_options' => ['label' => 'Confirmer votre mot de passe',
                    'attr' => [
                        'placeholder' => ''
                    ]
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'En cochant cette case, je certifie avoir lu et accepté les ' .
                    ' #CGU# du site.',
                'mapped' => false,
                'empty_data' => null,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions générale d\'utilisation du site.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
