<?php

namespace SolicitudBundle\Controller;

use SolicitudBundle\Entity\Solicitud;
use SolicitudBundle\Form\ReporteSolicitudType;
use SolicitudBundle\Entity\DetalleSolicitud;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Solicitud controller.
 *
 * @Route("solicitud")
 */
class SolicitudController extends Controller
{
    /**
     * Lists all solicitud entities.
     *
     * @Route("/", name="solicitud_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $solicituds = $em->getRepository('SolicitudBundle:Solicitud')->findAll();

        return $this->render('solicitud/index.html.twig', array(
            'solicituds' => $solicituds,
        ));
    }

    /**
     * Lists all inventario entities.
     *
     * @Route("/solicitud/listado/", name="solicitud_listado",options={"expose"=true})
     * @Method({"GET","POST"})
     */
    public function listadoAction(Request $request)
    {
        $cantidad=$request->get('length');
        $draw=$request->get('draw');
        $comienza=$request->get('start');
        $buscar=$request->get('search');
        $order=$request->get('order');
        $campo='s.id';
        $dir=$order[0]['dir'];
        switch ($order[0]['column']){
            case 1:
                $campo='s.id';
                break;
            case 2:
                $campo='s.nombrePaciente';
                break;
            case 3:
                $campo='s.fechaRegistro';
                break;
            case 4:
                $campo='s.observacion';
                break;
            case 5:
                $campo='s.estado';
                break;

        }
        $em = $this->getDoctrine()->getManager();
        $solicitudes = $em->getRepository('SolicitudBundle:Solicitud')->listadoAjax($cantidad,$comienza,$campo,$dir,$buscar['value']);

        $json = array();
        foreach ($solicitudes['result'] as $solicitud) {
            $json[] = array(
                'opcion'=>'',
                'id'=>(string)$solicitud->getId(),
                'paciente'=>$solicitud->getNombrePaciente(),
                'fechaRegistro'=>$solicitud->getFechaRegistroString(),
                'observacion'=>$solicitud->getObservacion(),
                'estadoString'=>$solicitud->getEstadoString(),
                'estado'=>$solicitud->getEstado(),
            );
        }
        $jsonReturn["draw"]=$draw;
        $jsonReturn["data"]=$json;
        $jsonReturn["recordsTotal"]=$solicitudes['cant'];
        $jsonReturn["recordsFiltered"]=$solicitudes['cant'];
        $response = new Response(json_encode($jsonReturn));
        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }

    /**
     * Creates a new solicitud entity.
     *
     * @Route("/new", name="solicitud_new",options={"expose"=true})
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $solicitud = new Solicitud();
        $form = $this->createForm('SolicitudBundle\Form\SolicitudType', $solicitud);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dump($form->getData());die();
            $em = $this->getDoctrine()->getManager();
            $em->persist($solicitud);
            foreach ($solicitud->getLaboratorio() as $laboratorio) {
                $detalleSolicitud= new DetalleSolicitud();
                $detalleSolicitud->setSolicitud($solicitud);
                $detalleSolicitud->setLaboratorio($laboratorio);
                $em->persist($detalleSolicitud);
            }
            $em->flush();

            return $this->redirectToRoute('solicitud_edit', array('id' => $solicitud->getId()));
        }

        return $this->render('solicitud/new.html.twig', array(
            'solicitud' => $solicitud,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a solicitud entity.
     *
     * @Route("/{id}", name="solicitud_show",options={"expose"=true})
     * @Method("GET")
     */
    public function showAction(Solicitud $solicitud)
    {

        return $this->render('solicitud/show.html.twig', array(
            'solicitud' => $solicitud
        ));
    }

    /**
     * Finds and displays a solicitud entity.
     *
     * @Route("/{id}/enviar/", name="solicitud_enviar",options={"expose"=true})
     * @Method("GET")
     */
    public function sendAction(Solicitud $solicitud)
    {
        $solicitud->setEstado('E');
        $solicitud->setFechaEnvio(new \DateTime());

        $this->getDoctrine()->getManager()->flush($solicitud);
        $this->get('session')->getFlashBag()->add('success', 'Solicitud enviada');

        return $this->render('solicitud/show.html.twig', array(
            'solicitud' => $solicitud
        ));
    }

    /**
     * Displays a form to edit an existing solicitud entity.
     *
     * @Route("/{id}/edit", name="solicitud_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Solicitud $solicitud)
    {
        foreach ($solicitud->getSolicitudDetalles() as $key => $detalle) {
            $solicitud->cargarLaboratorios($detalle->getLaboratorio());
        }
        $editForm = $this->createForm('SolicitudBundle\Form\SolicitudType', $solicitud);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Se guardaron los cambios');

            return $this->redirectToRoute('solicitud_edit', array('id' => $solicitud->getId()));
        }

        return $this->render('solicitud/edit.html.twig', array(
            'solicitud' => $solicitud,
            'edit_form' => $editForm->createView()
        ));
    }

    /**
     * Deletes a solicitud entity.
     *
     * @Route("/{id}/delete/solicitud", name="solicitud_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, Solicitud $solicitud)
    {
    
        $id=$solicitud->getId();
        $em = $this->getDoctrine()->getManager();
        $em->remove($solicitud);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', 'Se elimino la solicitud con Nº '.$id);

        return $this->redirectToRoute('solicitud_index');
    }

    /**
     * Displays a form to edit an existing solicitud entity.
     *
     * @Route("/reporte/", name="solicitud_reporte")
     * @Method({"GET", "POST"})
     */
    public function reporteAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $form = $this->createForm(new ReporteSolicitudType());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data=$form->getData();
            $resultado=$em->getRepository('SolicitudBundle:Solicitud')->findReportePorFechas($data['inicio'],$data['fin']);

            return $this->render('solicitud/reporte.html.twig', array(
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
     * Creates a form to delete a solicitud entity.
     *
     * @param Solicitud $solicitud The solicitud entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Solicitud $solicitud)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('solicitud_delete', array('id' => $solicitud->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
