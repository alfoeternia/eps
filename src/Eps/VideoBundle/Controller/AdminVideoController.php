<?php

namespace Eps\VideoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Eps\VideoBundle\Entity\Video;
use Eps\VideoBundle\Form\VideoType;

/**
 * Admin Video controller.
 *
 */
class AdminVideoController extends Controller
{

    /**
     * Lists all Video entities.
     *
     * @Route("/admin/videos", name="admin_video")
     * @Method("GET")
     * @Template("EpsVideoBundle:AdminVideo:index.html.twig")
     */
    public function indexAction($page = null)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EpsVideoBundle:Video')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Video entity.
     *
     * @Route("/admin/videos", name="admin_video_create")
     * @Method("POST")
     * @Template("EpsVideoBundle:AdminVideo:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Video();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
			
			return $this->redirect($this->generateUrl('admin_video_new_upload', 
                            array(  'id' => $entity->getId(),
                                    'year' => $entity->getYear()
                                 )));
        }

        return $this->render('EpsVideoBundle:AdminVideo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Video entity.
    *
    * @param Video $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Video $entity)
    {
        $form = $this->createForm(new VideoType(), $entity, array(
            'action' => $this->generateUrl('admin_video_create'),
            'method' => 'POST',
        ));

		
        $form->remove('url');
        $form->remove('source');
        $form->remove('thumb');

        return $form;
    }

    /**
     * Displays a form to create a new Video entity.
     *
     * @Route("/admin/video/new", name="admin_video_new")
     * @Method("GET")
     * @Template("EpsVideoBundle:AdminVideo:new.html.twig")
     */
    public function newAction()
    {
        $entity = new Video();
        $form   = $this->createCreateForm($entity);

        return $this->render('EpsVideoBundle:AdminVideo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
	
	public function newThumbAction($year, $id)
    {
        $request = $this->getRequest();
        $error = null;

        return $this->render('EpsVideoBundle:AdminVideo:newThumb.html.twig',
                        array(  'video_id' => $id,
                                'video_year' => $year,
                                'error' => $error));
    }

	public function newFinishAction($year, $id)
    {
        $error = null;
        return $this->render('EpsVideoBundle:AdminVideo:newFinish.html.twig',
                        array(  'video_id' => $id,
                                'video_year' => $year,
                                'error' => $error));
    }

    /**
     * Displays a dropzone for uploading images
     *
     */
    public function newUploadAction($year, $id)
    {
        return $this->render('EpsVideoBundle:AdminVideo:newUpload.html.twig',
                        array(  'video_id' => $id,
                                'video_year' => $year));
    }
	
	
    /**
     * Finds and displays a Video entity.
     *
     * @Route("/admin/video/{id}", name="admin_video_show")
     * @Method("GET")
     * @Template("EpsVideoBundle:AdminVideo:show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EpsVideoBundle:Video')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Video entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Video entity.
     *
     * @Route("/admin/video/{id}/edit", name="admin_video_edit")
     * @Method("GET")
     * @Template("EpsVideoBundle:AdminVideo:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EpsVideoBundle:Video')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Video entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Video entity.
    *
    * @param Video $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Video $entity)
    {
        $form = $this->createForm(new VideoType(), $entity, array(
            'action' => $this->generateUrl('admin_video_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Video entity.
     *
     * @Route("/admin/video/{id}", name="admin_video_update")
     * @Method("PUT")
     * @Template("EpsVideoBundle:AdminVideo:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EpsVideoBundle:Video')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Video entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_video_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Video entity.
     *
     * @Route("/admin/video/{id}", name="admin_video_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EpsVideoBundle:Video')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Video entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_video'));
    }

    /**
     * Creates a form to delete a Video entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_video_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
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
