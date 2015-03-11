<?php

namespace Eps\PhotoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Eps\UserBundle\Entity\UserRepository;
use Eps\VideoBundle\Entity\VideoRepository;

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
            ->add('reporters', 'entity', array(
                                            'multiple' => true,
                                            'class' => 'Eps\\UserBundle\\Entity\\User',
                                            'query_builder' => function(UserRepository $repository) {
                                                return $repository->getReporters();
                                            },))

            ->add('video', 'entity', array('required' => false,
                                            'label' => 'Vidéo',
                                            'class' => 'Eps\\VideoBundle\\Entity\\Video',
                                            'query_builder' => function(VideoRepository $repository) {
                                                return $repository->getAllForForm();
                                            },))
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
