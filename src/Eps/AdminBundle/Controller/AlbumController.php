<?php

namespace Eps\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;
use Eps\PhotoBundle\Entity\Album;


class AlbumController extends Controller
{
    
    public function indexAction($page = null)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('EpsPhotoBundle:Album')
                    ->createQueryBuilder('a')
                    ->orderBy('a.id', 'DESC')
                    ->join('a.category', 'c')
                    ->join('a.reporters', 'r')
                    ->addSelect('c')
                    ->addSelect('r')
                    ->getQuery();
        $albums = $query->getResult();

        $adapter = new ArrayAdapter($albums);

        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(15);

        if( !$page ) $page = 1;

        try {
            $pagerfanta->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {
            throw new NotFoundHttpException();
        }

        return $this->render('EpsAdminBundle:Album:index.html.twig', array( 'albums' => $albums,
                                                                            'pagerfanta' => $pagerfanta));
    }

    public function newAction()
    {
        $em = $this->getDoctrine()->getManager();
        $error = null;

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $album = new Album();
            $category = $em->getRepository('EpsPhotoBundle:Category')->findOneById($request->get('category'));

            $album->setName($request->get('name'));
            $album->setDate(new \DateTime($request->get('date')));
            $album->setAccess($request->get('access'));
            $album->setCategory($category);
            foreach($request->get('reporters') as $id) {
                $reporter = $em->getRepository('EpsUserBundle:User')->findOneById($id);
                $album->addReporter($reporter);
            }

            $em->persist($album);

            try {
                $em->flush();
            } catch (\PDOException $e) {
                $error .= $e->getMessage().'<br>';
            }

            if(!$error) {
                return $this->redirect($this->generateUrl('admin_album_new_upload', 
                            array(  'id' => $album->getId(),
                                    'year' => $album->getDate()->format("Y")
                                 )));
            }
            
        }

        // Fetch categories
        $categories = $em->getRepository('EpsPhotoBundle:Category')->findAll();

        // Fetch users
        $query = $em->getRepository('EpsUserBundle:User')
                    ->createQueryBuilder('u')
                    ->orderBy('u.username', 'ASC')
                    ->getQuery();
        $users = $query->getResult();

        // Fetch reporters from users
        $reporters = array();
        foreach($users as $user) {
            if( in_array('ROLE_BUREAU', $user->getRoles()) ||
                in_array('ROLE_MAJ', $user->getRoles()) ||
                in_array('ROLE_REPORTER', $user->getRoles()))
            $reporters[] = $user;
        }

        // Render the template
        return $this->render('EpsAdminBundle:Album:new.html.twig', 
                        array(  'categories'    => $categories,
                                'reporters'     => $reporters,
                                'error'         => $error,
            ));
    }

    public function newUploadAction($year, $id)
    {
        return $this->render('EpsAdminBundle:Album:newUpload.html.twig',
                        array(  'album_id' => $id,
                                'album_year' => $year));
    }

    public function newThumbAction($year, $id)
    {
        $path = $this->get('kernel')->getRootDir() . '/../web/miniatures/' . $id;
        $images = glob($path . "/*.jpg");
        $images = array_map('basename', $images);
        $request = $this->getRequest();
        $error = null;
       
        if ($request->getMethod() == 'POST') {
            $em = $this->getDoctrine()->getManager();
            $album = $em->getRepository('EpsPhotoBundle:Album')->findOneById($id);
            $album->setThumb($request->get('thumb'));
            
            try {
                $em->flush();
            } catch (\PDOException $e) {
                $error .= $e->getMessage().'<br>';
            }

            if(!$error) {
                return $this->redirect($this->generateUrl('admin_album_new_finish', 
                            array(  'id' => $album->getId(),
                                    'year' => $album->getDate()->format("Y")
                                 )));
            }
        }


        return $this->render('EpsAdminBundle:Album:newThumb.html.twig',
                        array(  'album_id' => $id,
                                'album_year' => $year,
                                'images' => $images,
                                'error' => $error));
    }

    public function newFinishAction($year, $id)
    {
        $path = $this->get('kernel')->getRootDir() . '/../web/miniatures/' . $id;
        $images = glob($path . "/*.jpg");
        $images = array_map('basename', $images);
        $request = $this->getRequest();
        $error = null;
       
        if ($request->getMethod() == 'POST') {
            $em = $this->getDoctrine()->getManager();
            $album = $em->getRepository('EpsPhotoBundle:Album')->findOneById($id);
            $album->setThumb($request->get('thumb'));
            
            try {
                $em->flush();
            } catch (\PDOException $e) {
                $error .= $e->getMessage().'<br>';
            }

            if(!$error) {
                return $this->redirect($this->generateUrl('admin_album_new_finish', 
                            array(  'id' => $album->getId(),
                                    'year' => $album->getDate()->format("Y")
                                 )));
            }
        }


        return $this->render('EpsAdminBundle:Album:newFinish.html.twig',
                        array(  'album_id' => $id,
                                'album_year' => $year,
                                'images' => $images,
                                'error' => $error));
    }

    public function ownAction($page = null)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('EpsPhotoBundle:Album')
                    ->createQueryBuilder('a')
                    ->orderBy('a.id', 'DESC')
                    ->join('a.category', 'c')
                    ->join('a.reporters', 'r')
                    ->addSelect('c')
                    ->addSelect('r')
                    ->where('r = :reporter')
                    ->getQuery();
        $query->setParameters(array('reporter' => $this->get('security.context')->getToken()->getUser()));
        $albums = $query->getResult();

        $adapter = new ArrayAdapter($albums);

        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(10);

        if( !$page ) $page = 1;

        try {
            $pagerfanta->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {
            throw new NotFoundHttpException();
        }

        return $this->render('EpsAdminBundle:Album:own.html.twig', array( 'albums' => $albums,
                                                                            'pagerfanta' => $pagerfanta));
    }

    /*public function createAction()
    {
    	if ($this->getRequest()->getMethod() == 'POST') {
    		if($this->getRequest()->get('title') != NULL) {
    			$page = new StaticPage();
    			$page->setTitle($this->getRequest()->get('title'));

    			$em = $this->getDoctrine()->getManager();
            	$em->persist($page);
            	$em->flush();
    		}
    	} 

    	return $this->redirect($this->generateUrl('admin_static'));
    }

    public function editAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
		
		$page = $em->getRepository('EpsStaticPagesBundle:StaticPage')->find($id);
		if($page == NULL) return $this->redirect($this->generateUrl('admin_static'));


    	if ($this->getRequest()->getMethod() == 'POST') {
    		if($this->getRequest()->get('title') != NULL) {
    			$page->setTitle($this->getRequest()->get('title'));
    			$page->setContent($this->getRequest()->get('content'));
            	$em->flush();
    		}
    		return $this->redirect($this->generateUrl('admin_static'));
    	} 

    	return $this->render('EpsAdminBundle:Static:edit.html.twig', array('page' => $page, "id" => $id));
    	
    }

    public function deleteAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
		
		$page = $em->getRepository('EpsStaticPagesBundle:StaticPage')->find($id);
		if($page != NULL) {
			$page = $em->getRepository('EpsStaticPagesBundle:StaticPage')->find($id);
			$em->remove($page);
			$em->flush();
		}

    	return $this->redirect($this->generateUrl('admin_static'));
    	
    }*/
}
