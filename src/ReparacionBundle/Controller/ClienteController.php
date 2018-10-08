<?php

namespace ReparacionBundle\Controller;

use ReparacionBundle\Entity\Cliente;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cliente controller.
 *
 * @Route("cliente")
 */
class ClienteController extends Controller
{
    /**
     * Lists all cliente entities.
     *
     * @Route("/", name="cliente_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $clientes = $em->getRepository('ReparacionBundle:Cliente')->findAll();

        return $this->render('cliente/index.html.twig', array(
            'clientes' => $clientes,
        ));
    }

    /**
     * Creates a new cliente entity.
     *
     * @Route("/new", name="cliente_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cliente = new Cliente();
        $form = $this->createForm('ReparacionBundle\Form\ClienteType', $cliente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cliente);
            $em->flush();

            return $this->redirectToRoute('cliente_show', array('id' => $cliente->getId()));
        }

        return $this->render('cliente/new.html.twig', array(
            'cliente' => $cliente,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new paciente entity.
     *
     * @Route("/create/new/", name="cliente_create")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(array('message' => 'Puedes acceder solo usando Ajax!'), 400);
        }
        $cliente = new Cliente();
        $form = $this->createClienteForm( $cliente);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cliente);
            $em->flush();

            $clienteNuevo = new Cliente();
            $formNuevo = $this->createClienteForm($clienteNuevo);
            return new JsonResponse(array('message' => 'Exitoso!',
                'form' => $this->renderView('cliente/new.html.twig',
                    array(
                        'cliente' => $clienteNuevo,
                        'formCliente' => $formNuevo->createView(),
                    )),
                'select'=>array('id'=>$cliente->getId(),'text'=>$cliente->getNombreCompleto())),
                     200);
        }

        $response = new JsonResponse(
            array(
        'message' => 'Error',
        'form' => $this->renderView('cliente/new.html.twig',
                array(
            'cliente' => $cliente,
            'formCliente' => $form->createView(),
        ))), 400);
 
        return $response;
    }

    /**
     * Finds and displays a cliente entity.
     *
     * @Route("/{id}", name="cliente_show")
     * @Method("GET")
     */
    public function showAction(Cliente $cliente)
    {
        $deleteForm = $this->createDeleteForm($cliente);

        return $this->render('cliente/show.html.twig', array(
            'cliente' => $cliente,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cliente entity.
     *
     * @Route("/{id}/edit", name="cliente_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Cliente $cliente)
    {
        $deleteForm = $this->createDeleteForm($cliente);
        $editForm = $this->createForm('ReparacionBundle\Form\ClienteType', $cliente);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cliente_edit', array('id' => $cliente->getId()));
        }

        return $this->render('cliente/edit.html.twig', array(
            'cliente' => $cliente,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cliente entity.
     *
     * @Route("/{id}", name="cliente_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Cliente $cliente)
    {
        $form = $this->createDeleteForm($cliente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cliente);
            $em->flush();
        }

        return $this->redirectToRoute('cliente_index');
    }

    /**
     * Creates a form to delete a cliente entity.
     *
     * @param Cliente $cliente The cliente entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Cliente $cliente)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cliente_delete', array('id' => $cliente->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    private function createClienteForm(Cliente $cliente)
    {
        $form = $this->createForm('ReparacionBundle\Form\ClienteType', $cliente,
                array(
            'action' => $this->generateUrl('cliente_create'),
            'method' => 'POST',
        ));
        return $form
        ;
    }
}
