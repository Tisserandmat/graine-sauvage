<?php

namespace App\Form;

use App\Entity\Vegetable;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class VegetableType extends AbstractType
{
    const MONTHS = ['Janvier'=>'Janv', 'Février'=>'Feb', 'Mars'=>'Mar','Avril' =>'Apr', 'Mai'=>'May',
        'Juin'=>'Jun', 'Juillet'=>'Jul','Août' =>'Aug', 'Septembre'=>'Sep',
        'Octobre'=>'Oct', 'Novembre'=>'Nov', 'Decembre'=>'Dec'];

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Tomate'
                ]])
            ->add('description', CKEditorType::class, array('input_sync' => true))
            ->add('latinName', TextType::class, [
                'label' => 'Nom latin',
                'attr' => [
                    'placeholder' => 'Solanum lycopersicum'
                ]])
            ->add('family', TextareaType::class, [
                'label' => 'famille',
                'attr' => [
                    'placeholder' => 'Famille du légume'
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
            ->add('harvestMonth', ChoiceType::class, [
                'choices' => self::MONTHS,
                'label' => 'Moi de récolte',
            ])
            ->add('soilType', TextType::class, [
                'label' => 'Type de sol',
                'attr' => [
                    'placeholder' => 'Sol limoneux'
                ]])//            ->add('seed')
            ->add('imageFile', VichFileType::class, [
                'required'      => false,
                'allow_delete'  => true, // not mandatory, default is true
                'download_uri' => true, // not mandatory, default is true
            ]);
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vegetable::class,
        ]);
    }
}
