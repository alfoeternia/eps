<?php

namespace Eps\ReporterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Eps\PhotoBundle\Entity\Album;


class AlbumCreateController extends Controller
{
    
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $error = null;

    	$request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $album = new Album();
            $category = $em->getRepository('EpsPhotoBundle:Category')->findOneById($request->get('category'));

            $album->setName($request->get('name'));
            $album->setDate(new \DateTime($request->get('date')));
            $album->setAccess($request->get('access'));
            $album->setCategory($category);
            foreach($request->get('reporters') as $id)
            {
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
                $base_folder = $this->get('kernel')->getRootDir() . '/../web';
                
                try {
                    mkdir($base_folder.'/miniatures/'.$album->getId());
                } catch (\ErrorException $e) {
                    $error .= 'Erreur lors de la création du dossier : /miniatures/'.$album->getId().'<br>';
                    $error .= $e->getMessage().'<br>';
                    $error .= 'Vous devrez le créer vous-même via le FTP.<br>';
                }
                $date = $album->getDate();
                $year = date('Y', strtotime($date->date));
                try {
                    !mkdir($base_folder.'/data/'.$year.'/'.$album->getId());
                } catch (\ErrorException $e) {
                    $error .= 'Erreur lors de la création du dossier : /data/'.$year.'/'.$album->getId().'<br>';
                    $error .= $e->getMessage().'<br>';
                    $error .= 'Vous devrez le créer vous-même via le FTP.<br>';
                }

                if(!$error) {
                    return $this->redirect($this->generateUrl('reporter_album_addphotos', array('id' => $album->getId())));
                }

                //return $this->render('EpsReporterBundle:AlbumCreate:upload.html.twig', array('error' => $error));
            }
            
        }

        
    	$categories = $em->getRepository('EpsPhotoBundle:Category')->findAll();
    	$query = $em->getRepository('EpsUserBundle:User')
                    ->createQueryBuilder('u')
                    ->orderBy('u.pseudo', 'ASC')
                    ->getQuery();
        $users = $query->getResult();
        $reporters = array();
    	foreach($users as $user) {
    		if(	in_array('ROLE_BUREAU', $user->getRoles()) ||
    			in_array('ROLE_MAJ', $user->getRoles()) ||
    			in_array('ROLE_REPORTER', $user->getRoles()))
    		$reporters[] = $user;
    	}

        return $this->render('EpsReporterBundle:AlbumCreate:index.html.twig', 
        				array(	'categories' 	=> $categories,
        						'reporters'		=> $reporters,
                                'error'         => $error,
        	));
    }

    public function addPhotosAction($id)
    {
        $request = $this->getRequest();

        $editId = $this->getRequest()->get('editId');
        if (!preg_match('/^\d+$/', $editId))
        {
            $editId = sprintf('%09d', mt_rand(0, 1999999999));
            $this->get('punk_ave.file_uploader')->syncFiles(
                array('from_folder' => 'attachments/' . $id, 
                  'to_folder' => 'tmp/attachments/' . $editId,
                  'create_to_folder' => true));
        }

        $existingFiles = $this->get('punk_ave.file_uploader')->getFiles(array('folder' => 'tmp/attachments/' . $editId));

        return $this->render('EpsReporterBundle:AlbumCreate:upload.html.twig', 
            array(  'albumId' => $id,
                    'editId' => $editId,
                    'existingFiles' => $existingFiles,
                ));
    }

    public function uploadAction()
    {
        $editId = $this->getRequest()->get('editId');
        if (!preg_match('/^\d+$/', $editId))
        {
            throw new Exception("Bad edit id");
        }

        $this->get('punk_ave.file_uploader')->handleFileUpload(array('folder' => 'tmp/attachments/' . $editId));
    }


}
