<?php
/**
 * Created by PhpStorm.
 * User: Тима
 * Date: 05.02.2018
 * Time: 18:08
 */

namespace Acme\StoreBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Acme\StoreBundle\Document\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UploadPersonalPhoto extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('path', FileType::class, array());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => UploadedFile::class));
    }
}