<?php
/**
 * Created by PhpStorm.
 * User: Тима
 * Date: 26.11.2017
 * Time: 21:53
 */
namespace Acme\StoreBundle\Form;

use Acme\StoreBundle\Document\User;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use \Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('login', TextType::class);
        $builder->add('password', PasswordType::class);;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }

    public function getBlockPrefix()
    {
        return 'login';
    }

}