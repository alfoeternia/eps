<?php

namespace Eps\PhotoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;

use Eps\PhotoBundle\Entity\Album;
use Eps\PhotoBundle\Form\AlbumType;

/**
 * Album controller.
 *
 */
class AlbumController extends Controller
{

    /**
     * Lists all Album entities.
     *
     */
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

        return $this->render('EpsPhotoBundle:Album:index.html.twig', array( 'albums' => $albums,
                                                                            'pagerfanta' => $pagerfanta));
    }
    /**
     * Creates a new Album entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Album();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_album_new_upload', 
                            array(  'id' => $entity->getId(),
                                    'year' => $entity->getDate()->format("Y")
                                 )));
        }

        return $this->render('EpsPhotoBundle:Album:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Album entity.
    *
    * @param Album $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Album $entity)
    {
        $form = $this->createForm(new AlbumType(), $entity, array(
            'action' => $this->generateUrl('admin_album_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Créer'));

        $form->remove('thumb');

        return $form;
    }

    /**
     * Displays a form to create a new Album entity.
     *
     */
    public function newAction()
    {
        $entity = new Album();
        $form   = $this->createCreateForm($entity);

        return $this->render('EpsPhotoBundle:Album:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    public function newThumbAction($year, $id)
    {
        $path = $this->get('kernel')->getRootDir() . '/../www/miniatures/' . $id;
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


        return $this->render('EpsPhotoBundle:Album:newThumb.html.twig',
                        array(  'album_id' => $id,
                                'album_year' => $year,
                                'images' => $images,
                                'error' => $error));
    }

    public function newFinishAction($year, $id)
    {
        $path = $this->get('kernel')->getRootDir() . '/../www/miniatures/' . $id;
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


        return $this->render('EpsPhotoBundle:Album:newFinish.html.twig',
                        array(  'album_id' => $id,
                                'album_year' => $year,
                                'images' => $images,
                                'error' => $error));
    }

    /**
     * Displays a dropzone for uploading images
     *
     */
    public function newUploadAction($year, $id)
    {
        return $this->render('EpsPhotoBundle:Album:newUpload.html.twig',
                        array(  'album_id' => $id,
                                'album_year' => $year));
    }

    /**
     * Finds and displays a Album entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EpsPhotoBundle:Album')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Album entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EpsPhotoBundle:Album:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Album entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EpsPhotoBundle:Album')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Album entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EpsPhotoBundle:Album:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Album entity.
    *
    * @param Album $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Album $entity)
    {
        $form = $this->createForm(new AlbumType(), $entity, array(
            'action' => $this->generateUrl('admin_album_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        $form->remove('thumb');

        return $form;
    }
    /**
     * Edits an existing Album entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EpsPhotoBundle:Album')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Album entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_album_edit', array('id' => $id)));
        }

        return $this->render('EpsPhotoBundle:Album:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Album entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EpsPhotoBundle:Album')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Album entity.');
            }

            $root_dir = $this->get('kernel')->getRootDir() . '/../www/';
            $originals_dir = $root_dir.'originals/'.$entity->getDate()->format('Y').'/'.$entity->getId();
            $data_dir = $root_dir.'data/'.$entity->getDate()->format('Y').'/'.$entity->getId();
            $miniatures_dir = $root_dir.'miniatures/'.$entity->getId();

            $em->remove($entity);
            $em->flush();

            // Remove folders if they exists
            if(is_dir($originals_dir)) $this->rmdir_custom($originals_dir);
            if(is_dir($data_dir)) $this->rmdir_custom($data_dir);
            if(is_dir($miniatures_dir)) $this->rmdir_custom($miniatures_dir);
        }

        return $this->redirect($this->generateUrl('admin_album'));
    }

    /**
     * Creates a form to delete a Album entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_album_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer'))
            ->getForm()
        ;
    }

    /**
     * Publish a Album entity.
     *
     */
    public function publishAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EpsPhotoBundle:Album')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Album entity.');
        }

        $entity->setPublished(!$entity->getPublished());

        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('admin_album'));
    }

    public function rmdir_custom($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
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
}
