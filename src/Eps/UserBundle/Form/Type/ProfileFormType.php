<?php

namespace Eps\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class ProfileFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('firstname', 'text', array('label' => 'form.firstname', 'translation_domain' => 'FOSUserBundle'));
        $builder->add('lastname', 'text', array('label' => 'form.lastname', 'translation_domain' => 'FOSUserBundle'));
        // $builder->add('country', 'country', array('label' => 'form.country', 'translation_domain' => 'FOSUserBundle'));
    }

    public function getName()
    {
        return 'eps_user_profile';
    }

}