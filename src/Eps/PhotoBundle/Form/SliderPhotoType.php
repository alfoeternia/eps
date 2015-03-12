<?php

namespace Eps\PhotoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Eps\UserBundle\Entity\UserRepository;
use Eps\PhotoBundle\Entity\AlbumRepository;

class SliderPhotoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('actif', null, array('required' => false, 'label' => 'Actif ?'))
            ->add('album', 'entity', array('required' => true,
            'label' => 'Album',
            'class' => 'Eps\\PhotoBundle\\Entity\\Album',
            'query_builder' => function(AlbumRepository $repository) {
                return $repository->getAllForForm();
            },))
            ->add('user', 'entity', array('required' => true,
            'label' => 'Reporter',
            'class' => 'Eps\\UserBundle\\Entity\\User',
            'query_builder' => function(UserRepository $repository) {
            return $repository->getReporters();
            },))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Eps\StaticPagesBundle\Entity\SliderPhoto'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'eps_homepagebundle_sliderphoto';
    }
}
