<?php

namespace App\Form;

use App\Entity\Seed;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class SeedType extends AbstractType
{
    const MONTHS = ['Janvier'=>'Janvier', 'Février'=>'Février', 'Mars'=>'Mars', 'Avril'=>'Avril', 'Mai'=>'Mai',
        'Juin'=>'Juin', 'Juillet'=>'Juillet', 'Août'=>'Août', 'Septembre'=>'Septembre',
        'Octobre'=>'Octobre', 'Novembre'=>'Novembre', 'Decembre'=>'Decembre'];

    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Graine de tomate'
                ]])

            ->add('description', CKEditorType::class, array('input_sync' => true))

            ->add('seeding', ChoiceType::class, [
                'choices' => self::MONTHS,
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
            ->add('imageFile', VichImageType::class, [
                'required'      => false,
                'allow_delete'  => true, // not mandatory, default is true
                'download_uri' => true, // not mandatory, default is true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Seed::class,
        ]);
    }
}
