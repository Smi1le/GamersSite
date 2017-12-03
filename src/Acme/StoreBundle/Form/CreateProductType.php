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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $categories = $this->processCategories($options);
        $builder->add('photos', CollectionType::class, array(
            "entry_type" => FileType::class,
            "allow_add" => true,
            'prototype' => true,));
        $builder->add('description', TextType::class);
        $builder->add('shortDescription', TextType::class);
        $builder->add('name', TextType::class);;
        $builder->add('addressList', CollectionType::class, array(
            'entry_type' => UrlType::class,
            'entry_options' => array(
                'attr' => array('class' => 'url-field', 'placeholder' => 'Введите url')
            ),
            'allow_add' => true,
            'prototype' => true,
            'prototype_data' => '',

        ));
        $builder->add("category", ChoiceType::class, array(
            'choices' => $categories
        ));
        $builder->add('characteristics', CollectionType::class, array(
            "entry_type" => TextType::class,
            "allow_add" => true,
            'prototype' => true,
            'prototype_data' => '',
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Product::class,
        ));
        $resolver->setRequired(array('categories'));
    }

    /**
     * @param $options array
     * @return array
     */
    private function processCategories($options) {
        $categories = explode('$', $options['categories']);
        $newList = array();
        for ($i = 1; $i < count($categories); $i++) {
            array_push($newList, array($categories[$i] => $categories[$i]));
        }
        return $newList;
    }

    public function getBlockPrefix()
    {
        return 'createProduct';
    }
}