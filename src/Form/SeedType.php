<?php

namespace App\Form;

use App\Entity\Seed;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                    'label' => 'Nom',
                    'attr' => [
                        'placeholder' => 'Graine de tomate'
                    ]])
            ->add('description', TextareaType::class, [
        'label' => 'Description',
        'attr' => [
            'placeholder' => 'Description de la graine'
        ]])
            ->add('seeding', TextType::class, [
                'label' => 'Semis',
                'attr' => [
                    'placeholder' => 'Mars'
                ]])
            ->add('price', TextType::class, [
        'label' => 'Prix',
        'attr' => [
            'placeholder' => '20'
        ]])
            ->add('vegetable', null, ['choice_label' => 'name'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Seed::class,
        ]);
    }
}
