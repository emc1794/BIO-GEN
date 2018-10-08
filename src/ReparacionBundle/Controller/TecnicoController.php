<?php

namespace ReparacionBundle\Controller;

use ReparacionBundle\Entity\Tecnico;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Tecnico controller.
 *
 * @Route("tecnico")
 */
class TecnicoController extends Controller
{
    /**
     * Lists all tecnico entities.
     *
     * @Route("/", name="tecnico_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tecnicos = $em->getRepository('ReparacionBundle:Tecnico')->findAll();

        return $this->render('tecnico/index.html.twig', array(
            'tecnicos' => $tecnicos,
        ));
    }

    /**
     * Creates a new tecnico entity.
     *
     * @Route("/new", name="tecnico_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tecnico = new Tecnico();
        $form = $this->createForm('ReparacionBundle\Form\TecnicoType', $tecnico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tecnico);
            $em->flush();

            return $this->redirectToRoute('tecnico_show', array('id' => $tecnico->getId()));
        }

        return $this->render('tecnico/new.html.twig', array(
            'tecnico' => $tecnico,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new paciente entity.
     *
     * @Route("/create/new/", name="tecnico_create")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(array('message' => 'Puedes acceder solo usando Ajax!'), 400);
        }
        $tecnico = new Tecnico();
        $form = $this->createTecnicoForm( $tecnico);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tecnico);
            $em->flush();

            $tecnicoNuevo = new Tecnico();
            $formNuevo = $this->createTecnicoForm($tecnicoNuevo);
            return new JsonResponse(array('message' => 'Exitoso!',
                'form' => $this->renderView('tecnico/new.html.twig',
                    array(
                        'tecnico' => $tecnicoNuevo,
                        'formTecnico' => $formNuevo->createView(),
                    )),
                'select'=>array('id'=>$tecnico->getId(),'text'=>$tecnico->getNombreCompleto())),
                     200);
        }

        $response = new JsonResponse(
            array(
        'message' => 'Error',
        'form' => $this->renderView('tecnico/new.html.twig',
                array(
            'tecnico' => $tecnico,
            'formTecnico' => $form->createView(),
        ))), 400);
 
        return $response;
    }

    /**
     * Finds and displays a tecnico entity.
     *
     * @Route("/{id}", name="tecnico_show")
     * @Method("GET")
     */
    public function showAction(Tecnico $tecnico)
    {
        $deleteForm = $this->createDeleteForm($tecnico);

        return $this->render('tecnico/show.html.twig', array(
            'tecnico' => $tecnico,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing tecnico entity.
     *
     * @Route("/{id}/edit", name="tecnico_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Tecnico $tecnico)
    {
        $deleteForm = $this->createDeleteForm($tecnico);
        $editForm = $this->createForm('ReparacionBundle\Form\TecnicoType', $tecnico);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tecnico_edit', array('id' => $tecnico->getId()));
        }

        return $this->render('tecnico/edit.html.twig', array(
            'tecnico' => $tecnico,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tecnico entity.
     *
     * @Route("/{id}", name="tecnico_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Tecnico $tecnico)
    {
        $form = $this->createDeleteForm($tecnico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tecnico);
            $em->flush();
        }

        return $this->redirectToRoute('tecnico_index');
    }

    /**
     * Creates a form to delete a tecnico entity.
     *
     * @param Tecnico $tecnico The tecnico entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tecnico $tecnico)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tecnico_delete', array('id' => $tecnico->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    private function createTecnicoForm(Tecnico $tecnico)
    {
        $form = $this->createForm('ReparacionBundle\Form\TecnicoType', $tecnico,
                array(
            'action' => $this->generateUrl('tecnico_create'),
            'method' => 'POST',
        ));
        return $form
        ;
    }
}
