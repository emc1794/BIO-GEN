<?php

namespace ReparacionBundle\Controller;

use ReparacionBundle\Entity\Solicitud;
use ReparacionBundle\Entity\Cliente;
use SolicitudBundle\Form\ReporteSolicitudType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/", name="solicitud_reparacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $solicituds = $em->getRepository('ReparacionBundle:Solicitud')->findAll();

        return $this->render('solicitud/index.html.twig', array(
            'solicituds' => $solicituds,
        ));
    }

    /**
     * Creates a new solicitud entity.
     *
     * @Route("/new", name="solicitud_reparacion_new",options={"expose"=true})
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $solicitud = new Solicitud();
        $cliente = new Cliente();
        $form = $this->createForm('ReparacionBundle\Form\SolicitudType', $solicitud);
        $formCliente= $this->createClienteForm($cliente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $cliente=$em->getRepository('ReparacionBundle:Cliente')->findOneById($solicitud->getClienteString());
            if (is_null($cliente)) {
                $this->get('session')->getFlashBag()->add('error', 'El cliente no existe');
                return $this->render('solicitud/new.html.twig', array(
                    'formCliente'=>$formCliente->createView(),
                    'solicitud' => $solicitud,
                    'form' => $form->createView(),
                ));
            }else{
                $solicitud->setCliente($cliente);
            }

            $solicitud->setRecepcionista($this->getUser()->getPersona());

            try{
                $em->persist($solicitud);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'Registro exitoso!');
                return $this->redirectToRoute('solicitud_reparacion_show', array('id' => $solicitud->getId()));
            }
            catch(Exception $e){
                 $this->get('session')->getFlashBag()->add('error', 'Error: '.$e->getMessage());
                return $this->redirectToRoute('solicitud_reparacion_new');

            }
        }

        return $this->render('solicitud/new.html.twig', array(
            'formCliente'=>$formCliente->createView(),
            'solicitud' => $solicitud,
            'form' => $form->createView(),
        ));
    }

    /**
     * Lists all inventario entities.
     *
     * @Route("/solicitud/listado/", name="listado_solicitud_reparacion",options={"expose"=true})
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
                $campo='c.cliente';
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
        $solicitudes = $em->getRepository('ReparacionBundle:Solicitud')->listadoAjax($cantidad,$comienza,$campo,$dir,$buscar['value']);

        $json = array();
        foreach ($solicitudes['result'] as $solicitud) {
            $json[] = array(
                'opcion'=>'',
                'id'=>(string)$solicitud->getId(),
                'cliente'=>$solicitud->getCliente()->getNombreCompleto(),
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
     * Finds and displays a solicitud entity.
     *
     * @Route("/{id}", name="solicitud_reparacion_show",options={"expose"=true})
     * @Method("GET")
     */
    public function showAction(Solicitud $solicitud)
    {
        $deleteForm = $this->createDeleteForm($solicitud);

        return $this->render('solicitud/show.html.twig', array(
            'solicitud' => $solicitud,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing solicitud entity.
     *
     * @Route("/{id}/edit", name="solicitud_reparacion_edit",options={"expose"=true})
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Solicitud $solicitud)
    {
        $deleteForm = $this->createDeleteForm($solicitud);
        $editForm = $this->createForm('ReparacionBundle\Form\SolicitudType', $solicitud);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em=$this->getDoctrine()->getManager();
            if ($solicitud->getClienteString()!=$solicitud->getCliente()->getId()) {
                $cliente2=$em->getRepository('ReparacionBundle:Cliente')->findOneById($solicitud->getClienteString());
                if (is_null($cliente2)) {
                    $this->get('session')->getFlashBag()->add('error', 'El cliente no existe');
                    return $this->render('solicitud/edit.html.twig', array(
                        'solicitud' => $solicitud,
                        'edit_form' => $editForm->createView(),
                    ));
                }else{
                    $solicitud->setCliente($cliente2);
                }
            }
            try{
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'Actualizacion exitosa!');
                return $this->redirectToRoute('solicitud_reparacion_show', array('id' => $solicitud->getId()));
            }
            catch(Exception $e){
                 $this->get('session')->getFlashBag()->add('error', 'Error: '.$e->getMessage());
                return $this->redirectToRoute('solicitud_reparacion_edit', array('id' => $solicitud->getId()));

            }

        }

        return $this->render('solicitud/edit.html.twig', array(
            'solicitud' => $solicitud,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing solicitud entity.
     *
     * @Route("/reporte/", name="solicitud_reparacion_reporte")
     * @Method({"GET", "POST"})
     */
    public function reporteAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $form = $this->createForm(new ReporteSolicitudType());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data=$form->getData();
            $resultado=$em->getRepository('ReparacionBundle:Solicitud')->findReportePorFechas($data['inicio'],$data['fin']);

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
