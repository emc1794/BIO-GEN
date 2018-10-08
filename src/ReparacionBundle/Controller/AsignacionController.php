<?php

namespace ReparacionBundle\Controller;

use ReparacionBundle\Entity\Asignacion;
use ReparacionBundle\Entity\Tecnico;
use SolicitudBundle\Form\ReporteSolicitudType;
use ReparacionBundle\Entity\DetalleSolicitud;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Asignacion controller.
 *
 * @Route("asignacion")
 */
class AsignacionController extends Controller
{
    /**
     * Lists all asignacion entities.
     *
     * @Route("/", name="asignacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {

        return $this->render('asignacion/index.html.twig'
        );
    }

    /**
     * Lists all inventario entities.
     *
     * @Route("/solicitud/listado/", name="listado_sin_asignacion",options={"expose"=true})
     * @Method({"GET","POST"})
     */
    public function listadoAction(Request $request)
    {
        $cantidad=$request->get('length');
        $draw=$request->get('draw');
        $comienza=$request->get('start');
        $buscar=$request->get('search');
        $order=$request->get('order');
        $campo='ds.id';
        $dir=$order[0]['dir'];
        switch ($order[0]['column']){
            case 1:
                $campo='ds.id';
                break;
            case 2:
                $campo='s.id';
                break;
            case 3:
                $campo='a.nombre';
                break;
            case 4:
                $campo='ds.descripcion';
                break;
            case 5:
                $campo='s.fechaRegistro';
                break;

        }
        $em = $this->getDoctrine()->getManager();
        $detalles = $em->getRepository('ReparacionBundle:DetalleSolicitud')->listadoAjax($cantidad,$comienza,$campo,$dir,$buscar['value']);

        $json = array();
        foreach ($detalles['result'] as $detalle) {
            $json[] = array(
                'opcion'=>'',
                'id'=>(string)$detalle->getId(),
                'orden'=>$detalle->getSolicitud()->getId(),
                'tipo'=>$detalle->getArtefacto()->getNombre(),
                'descripcion'=>$detalle->getDescripcion(),
                'fechaRegistro'=>$detalle->getSolicitud()->getFechaRegistroString(),
            );
        }
        $jsonReturn["draw"]=$draw;
        $jsonReturn["data"]=$json;
        $jsonReturn["recordsTotal"]=$detalles['cant'];
        $jsonReturn["recordsFiltered"]=$detalles['cant'];
        $response = new Response(json_encode($jsonReturn));
        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }

    /**
     * Creates a new asignacion entity.
     *
     * @Route("/new/{id}/", name="asignacion_new",options={"expose"=true})
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request,DetalleSolicitud $detalleSolicitud)
    {
        $asignacion = new Asignacion();
        $tecnico = new Tecnico();
        $asignacion->setDetalleSolicitud($detalleSolicitud);
        $form = $this->createForm('ReparacionBundle\Form\AsignacionType', $asignacion);
        $formTecnico= $this->createTecnicoForm($tecnico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $tecnico=$em->getRepository('ReparacionBundle:Tecnico')->findOneById($asignacion->getTecnicoId());
            if (is_null($tecnico)) {
                $this->get('session')->getFlashBag()->add('error', 'El tecnico no existe');
                return $this->render('asignacion/new.html.twig', array(
                    'formTecnico'=>$formTecnico->createView(),
                    'detalleSolicitud'=>$detalleSolicitud,
                    'asignacion' => $asignacion,
                    'form' => $form->createView(),
                ));
            }else{
                $asignacion->setAsignado($tecnico);
            }

            $asignacion->setAsignador($this->getUser()->getPersona());

            try{
                $em->persist($asignacion);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'Registro exitoso!');
                return $this->redirectToRoute('asignacion_show', array('id' => $asignacion->getId()));
            }
            catch(\Doctrine\ORM\ORMException $e){
                 $this->get('session')->getFlashBag()->add('error', 'Error: '.$e->getMessage());
                return $this->redirectToRoute('asignacion_new');

            }
        }

        return $this->render('asignacion/new.html.twig', array(
            'formTecnico'=>$formTecnico->createView(),
            'detalleSolicitud'=>$detalleSolicitud,
            'asignacion' => $asignacion,
            'form' => $form->createView(),
        ));
    }

    /**
     *
     * @Route("/reporte/", name="asignacion_reporte")
     * @Method({"GET", "POST"})
     */
    public function reporteAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $form = $this->createForm(new ReporteSolicitudType());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data=$form->getData();
            $resultado=$em->getRepository('ReparacionBundle:Asignacion')->findReportePorFechas($data['inicio'],$data['fin']);

            return $this->render('asignacion/reporte.html.twig', array(
                'form' => $form->createView(),
                'inicio'=>$data['inicio'],
                'fin'=>$data['fin'],
                'resultado'=>$resultado,
                'estado'=>true,
            ));
        }

        return $this->render('solicitud/reporte.html.twig', array(
            'form' => $form->createView(),
            'estado'=>false,
        ));
    }

    /**
     * Finds and displays a asignacion entity.
     *
     * @Route("/{id}", name="asignacion_show",options={"expose"=true})
     * @Method("GET")
     */
    public function showAction(Asignacion $asignacion)
    {
        return $this->render('asignacion/show.html.twig', array(
            'asignacion' => $asignacion
        ));
    }

    /**
     * Displays a form to edit an existing asignacion entity.
     *
     * @Route("/{id}/edit", name="asignacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Asignacion $asignacion)
    {
        $tecnico = new Tecnico();
        $detalleSolicitud= $asignacion->getDetalleSolicitud();
        $form = $this->createForm('ReparacionBundle\Form\AsignacionType', $asignacion);
        $formTecnico= $this->createTecnicoForm($tecnico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $tecnico=$em->getRepository('ReparacionBundle:Tecnico')->findOneById($asignacion->getTecnicoId());
            if (is_null($tecnico)) {
                $this->get('session')->getFlashBag()->add('error', 'El tecnico no existe');
                return $this->render('asignacion/new.html.twig', array(
                    'formTecnico'=>$formTecnico->createView(),
                    'detalleSolicitud'=>$detalleSolicitud,
                    'asignacion' => $asignacion,
                    'edit_form' => $form->createView(),
                ));
            }else{
                $asignacion->setAsignado($tecnico);
            }

            try{
                $em->persist($asignacion);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'Registro exitoso!');
                return $this->redirectToRoute('asignacion_show', array('id' => $asignacion->getId()));
            }
            catch(\Doctrine\ORM\ORMException $e){
                 $this->get('session')->getFlashBag()->add('error', 'Error: '.$e->getMessage());
                return $this->redirectToRoute('asignacion_edit', array('id' => $asignacion->getId()));

            }
        }

        return $this->render('asignacion/edit.html.twig', array(
            'formTecnico'=>$formTecnico->createView(),
            'detalleSolicitud'=>$detalleSolicitud,
            'asignacion' => $asignacion,
            'edit_form' => $form->createView(),
        ));
    }

    /**
     * Deletes a asignacion entity.
     *
     * @Route("/{id}", name="asignacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Asignacion $asignacion)
    {
        $form = $this->createDeleteForm($asignacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($asignacion);
            $em->flush();
        }

        return $this->redirectToRoute('asignacion_index');
    }

    /**
     * Creates a form to delete a asignacion entity.
     *
     * @param Asignacion $asignacion The asignacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Asignacion $asignacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('asignacion_delete', array('id' => $asignacion->getId())))
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
