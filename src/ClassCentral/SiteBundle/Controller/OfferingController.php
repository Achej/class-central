<?php

namespace ClassCentral\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ClassCentral\SiteBundle\Entity\Offering;
use ClassCentral\SiteBundle\Form\OfferingType;

/**
 * Offering controller.
 *
 */
class OfferingController extends Controller
{
    /**
     * Lists all Offering entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('ClassCentralSiteBundle:Offering')->findAll();

        return $this->render('ClassCentralSiteBundle:Offering:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Offering entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('ClassCentralSiteBundle:Offering')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Offering entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ClassCentralSiteBundle:Offering:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Offering entity.
     *
     */
    public function newAction($id)
    {
        $entity = new Offering();
        // Cloning the entity
        if($id) {
             $em = $this->getDoctrine()->getEntityManager();
             $entity = $em->getRepository('ClassCentralSiteBundle:Offering')->find($id);
        }
        $form   = $this->createForm(new OfferingType(), $entity);

        return $this->render('ClassCentralSiteBundle:Offering:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Offering entity.
     *
     */
    public function createAction()
    {
        $entity  = new Offering();
        $request = $this->getRequest();
        $form    = $this->createForm(new OfferingType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {                      
            $entity->setCreated(new \DateTime);
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('offering_show', array('id' => $entity->getId())));
            
        }

        return $this->render('ClassCentralSiteBundle:Offering:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Offering entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('ClassCentralSiteBundle:Offering')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Offering entity.');
        }

        $editForm = $this->createForm(new OfferingType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ClassCentralSiteBundle:Offering:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Offering entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('ClassCentralSiteBundle:Offering')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Offering entity.');
        }

        $editForm   = $this->createForm(new OfferingType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('offering_edit', array('id' => $id)));
        }

        return $this->render('ClassCentralSiteBundle:Offering:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function reportAction()
    {
        $offerings = $this->getDoctrine()->getRepository('ClassCentralSiteBundle:Offering')->findAllInCurrentMonth();
        return $this->render('ClassCentralSiteBundle:Offering:report.html.twig', array_merge($offerings, array()) );
    }

    /**
     * Deletes a Offering entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('ClassCentralSiteBundle:Offering')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Offering entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('offering'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
