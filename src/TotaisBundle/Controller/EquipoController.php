<?php

namespace TotaisBundle\Controller;

use TotaisBundle\Entity\Equipo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Equipo controller.
 *
 * @Route("equipo")
 */
class EquipoController extends Controller
{
    /**
     * Lists all equipo entities.
     *
     * @Route("/", name="equipo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $equipos = $em->getRepository('TotaisBundle:Equipo')->findAll();

        return $this->render('equipo/index.html.twig', array(
            'equipos' => $equipos,
        ));
    }

    /**
     * Creates a new equipo entity.
     *
     * @Route("/new", name="equipo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $equipo = new Equipo();
        $form = $this->createForm('TotaisBundle\Form\EquipoType', $equipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $usuario=$this->getUser()->getPersona();
            $equipo->setEmpleado($usuario);
            $em->persist($equipo);
            $em->flush();

            return $this->redirectToRoute('equipo_show', array('id' => $equipo->getId()));
        }

        return $this->render('equipo/new.html.twig', array(
            'equipo' => $equipo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a equipo entity.
     *
     * @Route("/{id}", name="equipo_show")
     * @Method("GET")
     */
    public function showAction(Equipo $equipo)
    {
        $deleteForm = $this->createDeleteForm($equipo);

        return $this->render('equipo/show.html.twig', array(
            'equipo' => $equipo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing equipo entity.
     *
     * @Route("/{id}/edit", name="equipo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Equipo $equipo)
    {
        $deleteForm = $this->createDeleteForm($equipo);
        $editForm = $this->createForm('TotaisBundle\Form\EquipoType', $equipo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('equipo_edit', array('id' => $equipo->getId()));
        }

        return $this->render('equipo/edit.html.twig', array(
            'equipo' => $equipo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a equipo entity.
     *
     * @Route("/{id}", name="equipo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Equipo $equipo)
    {
        $form = $this->createDeleteForm($equipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($equipo);
            $em->flush();
        }

        return $this->redirectToRoute('equipo_index');
    }

    /**
     * Creates a form to delete a equipo entity.
     *
     * @param Equipo $equipo The equipo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Equipo $equipo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('equipo_delete', array('id' => $equipo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
