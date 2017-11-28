<?php
/**
 * Created by PhpStorm.
 * User: Тима
 * Date: 25.11.2017
 * Time: 17:15
 */

namespace Acme\StoreBundle\Form;

use Acme\StoreBundle\Document\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('login', TextType::class);
//        $builder->add('password', PasswordType::class);
        $builder->add('plainPassword', RepeatedType::class, array("type" => PasswordType::class,
            'first_options'  => array('label' => 'Password'),
            'second_options' => array('label' => 'Repeat Password')));
        $builder->add('email', EmailType::class);
        $builder->add('nickname', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
           'data_class' => User::class,
        ));
    }

    public function getBlockPrefix()
    {
        return 'registration';
    }

}