<?php

namespace ReparacionBundle\Controller;

use ReparacionBundle\Entity\DetalleSolicitud;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Detallesolicitud controller.
 *
 * @Route("detallesolicitud")
 */
class DetalleSolicitudController extends Controller
{
    /**
     * Lists all detalleSolicitud entities.
     *
     * @Route("/", name="detallesolicitud_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $detalleSolicituds = $em->getRepository('ReparacionBundle:DetalleSolicitud')->findAll();

        return $this->render('detallesolicitud/index.html.twig', array(
            'detalleSolicituds' => $detalleSolicituds,
        ));
    }

    /**
     * Creates a new detalleSolicitud entity.
     *
     * @Route("/new", name="detallesolicitud_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $detalleSolicitud = new Detallesolicitud();
        $form = $this->createForm('ReparacionBundle\Form\DetalleSolicitudType', $detalleSolicitud);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($detalleSolicitud);
            $em->flush();

            return $this->redirectToRoute('detallesolicitud_show', array('id' => $detalleSolicitud->getId()));
        }

        return $this->render('detallesolicitud/new.html.twig', array(
            'detalleSolicitud' => $detalleSolicitud,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a detalleSolicitud entity.
     *
     * @Route("/{id}", name="detallesolicitud_show")
     * @Method("GET")
     */
    public function showAction(DetalleSolicitud $detalleSolicitud)
    {
        $deleteForm = $this->createDeleteForm($detalleSolicitud);

        return $this->render('detallesolicitud/show.html.twig', array(
            'detalleSolicitud' => $detalleSolicitud,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing detalleSolicitud entity.
     *
     * @Route("/{id}/edit", name="detallesolicitud_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, DetalleSolicitud $detalleSolicitud)
    {
        $deleteForm = $this->createDeleteForm($detalleSolicitud);
        $editForm = $this->createForm('ReparacionBundle\Form\DetalleSolicitudType', $detalleSolicitud);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('detallesolicitud_edit', array('id' => $detalleSolicitud->getId()));
        }

        return $this->render('detallesolicitud/edit.html.twig', array(
            'detalleSolicitud' => $detalleSolicitud,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a detalleSolicitud entity.
     *
     * @Route("/{id}", name="detallesolicitud_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, DetalleSolicitud $detalleSolicitud)
    {
        $form = $this->createDeleteForm($detalleSolicitud);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($detalleSolicitud);
            $em->flush();
        }

        return $this->redirectToRoute('detallesolicitud_index');
    }

    /**
     * Creates a form to delete a detalleSolicitud entity.
     *
     * @param DetalleSolicitud $detalleSolicitud The detalleSolicitud entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DetalleSolicitud $detalleSolicitud)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('detallesolicitud_delete', array('id' => $detalleSolicitud->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
