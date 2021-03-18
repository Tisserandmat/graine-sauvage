<?php

namespace App\Form;

use App\Entity\Vegetable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VegetableSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', SearchType::class, [
                'attr' => [
                    'placeholder' => 'Entrez le nom d\'un légume'
                ]
            ]);
//            ->add('submit', ButtonType::class, [
//                'attr' => ['class' => 'Rechercher'],
//          'row_attr' => ['class' => 'text-editor', 'id' => '...'],
//            ])
//        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vegetable::class,
        ]);
    }
}
