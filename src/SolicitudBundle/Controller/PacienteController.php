<?php

namespace SolicitudBundle\Controller;

use SolicitudBundle\Entity\Paciente;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Paciente controller.
 *
 * @Route("paciente")
 */
class PacienteController extends Controller
{
    /**
     * Lists all paciente entities.
     *
     * @Route("/", name="paciente_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pacientes = $em->getRepository('SolicitudBundle:Paciente')->findAll();

        return $this->render('paciente/index.html.twig', array(
            'pacientes' => $pacientes,
        ));
    }

    /**
     * Creates a new paciente entity.
     *
     * @Route("/new", name="paciente_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $paciente = new Paciente();
        $form = $this->createPacienteForm($paciente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($paciente);
            $em->flush();

            return $this->redirectToRoute('paciente_show', array('id' => $paciente->getId()));
        }

        return $this->render('paciente/new.html.twig', array(
            'paciente' => $paciente,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new paciente entity.
     *
     * @Route("/create/new/", name="paciente_create")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(array('message' => 'Puedes acceder solo usando Ajax!'), 400);
        }
        $paciente = new Paciente();
        $form = $this->createPacienteForm( $paciente);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($paciente);
            $em->flush();
            //print_r($paciente);die();

            $pacienteNuevo = new Paciente();
            $formNuevo = $this->createPacienteForm($pacienteNuevo);
            return new JsonResponse(array('message' => 'Exitoso!',
                'form' => $this->renderView('paciente/new.html.twig',
                    array(
                        'paciente' => $pacienteNuevo,
                        'formPaciente' => $formNuevo->createView(),
                    )),
                'select'=>array('id'=>$paciente->getId(),'text'=>$paciente->getNombreCompleto())),
                     200);
        }

        $response = new JsonResponse(
            array(
        'message' => 'Error',
        'form' => $this->renderView('paciente/new.html.twig',
                array(
            'paciente' => $paciente,
            'formPaciente' => $form->createView(),
        ))), 400);
 
        return $response;
    }

    /**
     * Finds and displays a paciente entity.
     *
     * @Route("/{id}", name="paciente_show")
     * @Method("GET")
     */
    public function showAction(Paciente $paciente)
    {
        $deleteForm = $this->createDeleteForm($paciente);

        return $this->render('paciente/show.html.twig', array(
            'paciente' => $paciente,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing paciente entity.
     *
     * @Route("/{id}/edit", name="paciente_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Paciente $paciente)
    {
        $deleteForm = $this->createDeleteForm($paciente);
        $editForm = $this->createForm('SolicitudBundle\Form\PacienteType', $paciente);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('paciente_edit', array('id' => $paciente->getId()));
        }

        return $this->render('paciente/edit.html.twig', array(
            'paciente' => $paciente,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a paciente entity.
     *
     * @Route("/{id}", name="paciente_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Paciente $paciente)
    {
        $form = $this->createDeleteForm($paciente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($paciente);
            $em->flush();
        }

        return $this->redirectToRoute('paciente_index');
    }

    /**
     * Creates a form to delete a paciente entity.
     *
     * @param Paciente $paciente The paciente entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Paciente $paciente)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('paciente_delete', array('id' => $paciente->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    private function createPacienteForm(Paciente $paciente)
    {
        $form = $this->createForm('SolicitudBundle\Form\PacienteType', $paciente,
                array(
            'action' => $this->generateUrl('paciente_create'),
            'method' => 'POST',
        ));
        return $form
        ;
    }

    /**
     * @Route("/paciente/ajax/", name="paciente_ajax")
     */
    public function ajaxAction(Request $request)
    {
        $value = $request->get('search');
        $em = $this->getDoctrine()->getManager();

        $pacientes = $em->getRepository('SolicitudBundle:Paciente')->findAjaxValue($value);


        $json = array();
        foreach ($pacientes as $paciente) {
            $json[] = array(
                'text' => $paciente->getNombreCompleto(),
                'id' => $paciente->getId()
            );
        }
        $jasonReturn["results"]=$json;
        $response = new Response(json_encode($jasonReturn));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
