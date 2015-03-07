<?php

namespace Eps\PhotoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
            ->add('album', null, array('required' => true, 'label' => 'Album'))
            ->add('user', null, array('required' => true, 'label' => 'Reporter'))
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
