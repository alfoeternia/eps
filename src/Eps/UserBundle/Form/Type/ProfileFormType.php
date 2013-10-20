<?php

namespace Eps\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class ProfileFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('firstname', 'text', array('label' => 'Prénom :'));
        $builder->add('lastname', 'text', array('label' => 'Nom :'));
        $builder->add('file');
    }

    public function getName()
    {
        return 'eps_user_profile';
    }

}