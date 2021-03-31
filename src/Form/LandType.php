<?php

namespace App\Form;

use App\Entity\Land;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class LandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
              'label' => 'Nom de l\'annonce',
              'attr' => [
                'placeholder' => 'potager a Saran à louer'
              ]])
            ->add('description', CKEditorType::class, array('input_sync' => true))
            ->add('city', TextType::class, [
              'label' => 'Ville'
            ])
            ->add('address', TextType::class, [
              'label'=>'Adresse'
            ])

            ->add('zipCode', textType::class, [
              'label' => 'Code postal'
              ])

            ->add('price', MoneyType::class, [
              'label' => 'prix mensuelle'
            ])
          ->add('imageFile', VichFileType::class, [
            'required'      => false,
            'allow_delete'  => true, // not mandatory, default is true
            'download_uri' => true, // not mandatory, default is true
          ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Land::class,
        ]);
    }
}
