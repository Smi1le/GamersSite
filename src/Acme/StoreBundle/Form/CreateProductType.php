<?php
/**
 * Created by PhpStorm.
 * User: Тима
 * Date: 28.11.2017
 * Time: 19:11
 */

namespace Acme\StoreBundle\Form;


use Acme\StoreBundle\Document\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('photos', CollectionType::class, array(
            "entry_type" => FileType::class,
            "allow_add" => true,
            'prototype' => true,));
//        $builder->add('description', TextType::class);
//        $builder->add('shortDescription', TextType::class);
//        $builder->add('name', TextType::class);;
//        $builder->add('addressList', TextType::class);;
        $builder->add('characteristics', CollectionType::class, array(
            "entry_type" => TextType::class,
            "allow_add" => true,
            'prototype' => true,
            'prototype_data' => 'New Tag Placeholder',
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Product::class,
        ));
    }

    public function getBlockPrefix()
    {
        return 'createProduct';
    }
}