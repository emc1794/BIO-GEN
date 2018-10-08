<?php

namespace ReparacionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('ReparacionBundle:Default:index.html.twig');
    }

    /**
     * @Route("/cliente/ajax/", name="cliente_ajax")
     */
    public function ajaxAction(Request $request)
    {
        $value = $request->get('search');
        $em = $this->getDoctrine()->getManager();

        $clientes = $em->getRepository('ReparacionBundle:Cliente')->findAjaxValue($value);


        $json = array();
        foreach ($clientes as $cliente) {
            $json[] = array(
                'text' => $cliente->getNombreCompleto(),
                'id' => $cliente->getId()
            );
        }
        $jasonReturn["results"]=$json;
        $response = new Response(json_encode($jasonReturn));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/tecnico/ajax/", name="tecnico_ajax")
     */
    public function ajaxTecnicoAction(Request $request)
    {
        $value = $request->get('search');
        $em = $this->getDoctrine()->getManager();

        $tecnicos = $em->getRepository('ReparacionBundle:Tecnico')->findAjaxValue($value);


        $json = array();
        foreach ($tecnicos as $tecnico) {
            $json[] = array(
                'text' => $tecnico->getNombreCompleto(),
                'id' => $tecnico->getId()
            );
        }
        $jasonReturn["results"]=$json;
        $response = new Response(json_encode($jasonReturn));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
