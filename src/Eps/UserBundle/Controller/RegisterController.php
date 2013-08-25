<?php

namespace Eps\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Eps\UserBundle\Entity\User;

class RegisterController extends Controller
{
    
    public function step1Action()
    {
        return $this->render('EpsUserBundle:Register:step1.html.twig');
    }
	
	public function step2Action()
    {
		$sso = new \SSO_Efrei();
		$link = $sso->userloginLink('ssotest.php');
        return $this->render('EpsUserBundle:Register:step2.html.twig', array('link' => $link));
    }
	
	public function step2checkAction()
    {
		$sso = new \SSO_Efrei();
		$isValid = $sso->userAuthenticate($sso->getTicket());
		
		if(!$isValid) {
			//throw new HttpException(403, $sso->getStrError($sso->getError()));
			$link = $sso->userloginLink('ssotest.php');
			return $this->render('EpsUserBundle:Register:step2.html.twig', 
								array('link' => $link,
									  'error' => $sso->getStrError($sso->getError())));
		}
		
		$data = $sso->getResponseData();
		$this->getRequest()->getSession()->set('ssodata', $data);
		
        return $this->render('EpsUserBundle:Register:step3.html.twig', array('data' => $sso->getResponseData()));
    }
	
	public function step3Action()
    {
        $em = $this->getDoctrine()->getEntityManager();
		$request = $this->getRequest();
		$session = $this->getRequest()->getSession();
		$ssodata = $session->get('ssodata');
		
		$factory = $this->get('security.encoder_factory');
		$user = new User();
		$encoder = $factory->getEncoder($user);

		if ($request->getMethod() != 'POST')
		{
			$error = 'Une erreur est survenue, merci de rééssayer.';
			return $this->render('EpsUserBundle:Register:step3.html.twig', array('error' => $error, 'data' => $ssodata));
		}
		
		if(	strlen($request->get('password')) < 6 ||
			$request->get('password') != $request->get('password2'))
		{
			$error = 'Erreur lors de la vérification du mot de passe. Pour rappel, il doit faire au moins 6 caractères.';
			return $this->render('EpsUserBundle:Register:step3.html.twig', array('error' => $error, 'data' => $ssodata));
		}
		
		$duplicate = $em->getRepository('EpsUserBundle:User')->findOneByUsername($ssodata['user']);
		if($duplicate != NULL)
		{
			$error = 'Erreur: Vous êtes déjà inscrit !';
			return $this->render('EpsUserBundle:Register:step3.html.twig', array('error' => $error, 'data' => $ssodata));
		}
		
		$password = $encoder->encodePassword($request->get('password'), $user->getSalt());
		
		$user->setUsername($ssodata['user']);
		$user->setEfreiUID($ssodata['uid']);
		$user->setFirstname($ssodata['firstname']);
		$user->setLastname($ssodata['lastname']);
		$user->setEmail($ssodata['email']);
		$user->setPseudo($request->get('pseudo'));
		$user->setPassword($password);
		
		$em->persist($user);
		$em->flush();
		
		$message = \Swift_Message::newInstance()
			->setSubject('Bienvenue sur EPS')
			->setFrom('no-reply@eps.assos.efrei.fr')
			->setTo($ssodata['email'])
			->setBody($this->renderView('EpsUserBundle:Register:email.txt.twig', array('data' => $ssodata)))
		;
		$this->get('mailer')->send($message);
		
		return $this->render('EpsUserBundle:Register:step4.html.twig');
    }
	
	public function step4Action()
    {
        //return $this->render('EpsUserBundle:Register:step1.html.twig');
    }
}
