<?php

namespace Eps\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('firstname', 'text', array('label' => 'Prénom :'));
        $builder->add('lastname', 'text', array('label' => 'Nom :'));
        // $builder->add('country', 'country', array('label' => 'form.country', 'translation_domain' => 'FOSUserBundle'));
        // $builder->add('captcha', 'captcha', array('label' => 'form.captcha', 'translation_domain' => 'FOSUserBundle'));
        // $builder->add('termsAccepted', 'checkbox', array('label' => 'form.terms', 'translation_domain' => 'FOSUserBundle', 'required'  => true));
    }

    public function getName()
    {
        return 'eps_user_registration';
    }

}