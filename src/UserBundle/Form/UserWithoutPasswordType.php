<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 20/01/16
 * Time: 14:20
 */



namespace Core\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class UserWithoutPasswordType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $genders = array(
            "M" => "M",
            "Mme" => "Mme",
            "Mlle" => "Mlle"
        );

        $builder
            ->add('gender', 'choice', array(
                'choices' => $genders,
                'choices_as_values' => true,
            ))
            ->remove('plainPassword')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Core\UserBundle\Entity\User'
        ));
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'core_userbundle_user_without_password';
    }

    public function getParent()
    {
        return new BaseUserType();
    }

}