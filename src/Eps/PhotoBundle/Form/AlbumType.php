<?php

namespace Eps\PhotoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AlbumType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array('label' => 'Titre'))
            ->add('date', 'date')
            ->add('thumb', null, array('label' => 'Miniature'))
            ->add('published', null, array('required' => false, 'label' => 'Publié ?'))
            ->add('access', 'choice', array(
                    'label' => 'Accès',
                    'choices'   => array(
                        'ROLE_REPORTER' => 'Privée - interne à EPS',
                        'ROLE_USER' => 'Privée',
                        'IS_AUTHENTICATED_ANONYMOUSLY' => 'Publique')))
            ->add('visit_count', null, array('label' => 'Visites'))
            ->add('like_count', null, array('label' => 'Likes'))
            ->add('category', null, array('label' => 'Catégorie'))
            ->add('reporters')
            ->add('video', null, array('required' => false, 'label' => 'Vidéo'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Eps\PhotoBundle\Entity\Album'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'eps_photobundle_album';
    }
}
