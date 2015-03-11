<?php

namespace Eps\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array('label' => 'Login'))
            ->add('email', null, array('label' => 'E-mail'))
            ->add('enabled', null, array('required' => false, 'label' => 'Activé'))
            ->add('lastLogin', null, array('label' => 'Dernière connexion'))
            ->add('locked', null, array('required' => false, 'label' => 'Bloqué'))
            ->add('expired', null, array('label' => 'Expiré'))
            ->add('roles', 'collection',  array('allow_add' => true,
            'allow_delete' => true,'required' => false,'label' => 'Rôle',
                                                                             'type' => 'choice',
                                                                             'options' => array(
                                                                       'choices'  => array('ROLE_REPORTER' => 'Reporter',
            'ROLE_BUREAU' => 'Bureau',
            'ROLE_MAJ' => 'Respo Maj'))))

            ->add('rank', 'choice', array('label' => 'Rang','choices' =>
                                                                     array('FORMER_REPORTER' => 'Ancien Reporter',
                                                                     'GODFATHER' => 'Parrain',
                                                                     'REPORTER' => 'Reporter',
                                                                     'TREASURER' => 'Trésorier',
                                                                     'PRESIDENT' => 'Président',
                                                                     'SECRETARY' => 'Secrétaire',
                                                                     'USER' => 'Utilisateur')))
            ->add('firstname', null, array('label' => 'Prénom'))
            ->add('lastname', null, array('label' => 'Nom'))
            ->add('promo', null, array('label' => 'Promo'))
            ->add('description', null, array('label' => 'Description'))
            ->add('landline', null, array('label' => 'Téléphone'))
            ->add('mobile', null, array('label' => 'Mobile'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Eps\UserBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'eps_userbundle_user';
    }
}
