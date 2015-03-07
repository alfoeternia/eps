<?php

namespace Eps\VideoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VideoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array('label' => 'Titre'))
            ->add('description', null, array('label' => 'Description'))
            ->add('year', null, array('label' => 'Année'))
			->add('download_count', null, array('label' => 'Nombre de téléchargement'))
            ->add('access', 'choice', array(
                    'label' => 'Accès',
                    'choices'   => array(
                        'ROLE_REPORTER' => 'Privée - interne à EPS',
                        'ROLE_USER' => 'Privée',
                        'IS_AUTHENTICATED_ANONYMOUSLY' => 'Publique')))
            ->add('url', null, array('label' => 'Url ou nom du fichier sur le ftp'))
            ->add('thumb', null, array('label' => 'Miniature'))
            ->add('source', 'choice', array(
                    'choices'   => array(
                        'LOCAL' => 'Vidéo locale (FTP)',
                        'YOUTUBE' => 'Youtube',
                        'VIMEO' => 'Vimeo')))
            ->add('reporters')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Eps\VideoBundle\Entity\Video'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'eps_videobundle_video';
    }
}
