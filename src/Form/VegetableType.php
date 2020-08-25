<?php

namespace App\Form;

use App\Entity\Vegetable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VegetableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Tomate'
                ]])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Description de la graine'
                ]])
            ->add('latinName', TextType::class, [
                'label' => 'Nom latin',
                'attr' => [
                    'placeholder' => 'Solanum lycopersicum'
                ]])
            ->add('family', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Description de la plante'
                ]])
            ->add('type', TextareaType::class, [
                'label' => 'type',
                'attr' => [
                    'placeholder' => 'type de plante'
                ]])
            ->add('size', IntegerType::class, [
                'label' => 'Taille',
                'attr' => [
                    'placeholder' => '18'
                ]])
            ->add('harvestMonth', TextType::class, [
                'label' => 'Moi de récolte',
                'attr' => [
                    'placeholder' => 'Mars'
                ]])
            ->add('soilType', TextType::class, [
                'label' => 'Type de sol',
                'attr' => [
                    'placeholder' => 'Sol limoneux'
                ]])//            ->add('seed')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vegetable::class,
        ]);
    }
}
