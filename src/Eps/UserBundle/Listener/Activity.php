<?php
 
namespace Eps\UserBundle\Listener;
 
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use DateTime;
use Eps\UserBundle\Entity\User;
 
class Activity
{
    protected $container;
    protected $em;
 
    public function __construct(ContainerInterface $container, Doctrine $doctrine)
    {
        $this->container = $container;
        $this->em = $doctrine->getManager();
    }
 
    /**
     * On each request we want to update the user's last activity datetime
     *
     * @param \Symfony\Component\HttpKernel\Event\FilterControllerEvent $event
     * @return void
     */
    public function onCoreController(FilterControllerEvent $event)
    {
        $token = $this->container->get('security.context')->getToken();
        $user = null;

        if(is_object($token)) $user = $token->getUser();

        if($user instanceof User)
        {
            $user->setLastActivity(new DateTime());
 
            $this->em->persist($user);
            $this->em->flush($user);
        }
    }
}