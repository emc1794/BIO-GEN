<?php

namespace ReparacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Solicitud
 *
 * @ORM\Table(name="solicitud")
 * @ORM\Entity(repositoryClass="ReparacionBundle\Repository\SolicitudRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Solicitud
{
    public function __construct() {
        $this->solicitudDetalles = new ArrayCollection();
    }
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaRegistro", type="datetime")
     */
    private $fechaRegistro;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=1)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="string", length=255,nullable=true)
     */
    private $observacion;

    /**
     * One Solicitud has Many SolicitudDetalles.
     * @ORM\OneToMany(targetEntity="DetalleSolicitud", mappedBy="solicitud",cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $solicitudDetalles;


    /**
     * Many detalles have One solicitud.
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="solicitud")
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
     */
    private $cliente;

    /**
     * Many detalles have One solicitud.
     * @ORM\ManyToOne(targetEntity="Recepcionista", inversedBy="solicitud")
     * @ORM\JoinColumn(name="recepcionista_id", referencedColumnName="id")
     */
    private $recepcionista;

    private $clienteString;

    /**
     * @ORM\PrePersist
     */
    public function prePresist()
    {
        $this->estado='R';
        $this->fechaRegistro=new \DateTime();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     *
     * @return Solicitud
     */
    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    /**
     * Get fechaRegistro
     *
     * @return \DateTime
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    public function getFechaRegistroString()
    {
        return (is_null($this->fechaRegistro))?'':$this->fechaRegistro->format('d-m-Y h:m');
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return Solicitud
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    public function getEstadoString()
    {
        $nuevoEstado='';
        switch ($this->estado)
        {
            case 'R':
                $nuevoEstado='Recepcionado|R|';
                break;
            case 'B':
                $nuevoEstado='Borrador|B|';
                break;
            case 'T':
                $nuevoEstado='Terminado|T|';
                break;
        }
        return $nuevoEstado;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     *
     * @return Solicitud
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Add solicitudDetalle
     *
     * @param \ReparacionBundle\Entity\DetalleSolicitud $solicitudDetalle
     *
     * @return Solicitud
     */
    public function addSolicitudDetalle(\ReparacionBundle\Entity\DetalleSolicitud $solicitudDetalle)
    {
        $solicitudDetalle->setSolicitud($this);
        $this->solicitudDetalles[] = $solicitudDetalle;

        return $this;
    }

    /**
     * Remove solicitudDetalle
     *
     * @param \ReparacionBundle\Entity\DetalleSolicitud $solicitudDetalle
     */
    public function removeSolicitudDetalle(\ReparacionBundle\Entity\DetalleSolicitud $solicitudDetalle)
    {
        $this->solicitudDetalles->removeElement($solicitudDetalle);
    }

    /**
     * Get solicitudDetalles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSolicitudDetalles()
    {
        return $this->solicitudDetalles;
    }


    /**
     * Set cliente
     *
     * @param \ReparacionBundle\Entity\Cliente $cliente
     *
     * @return Solicitud
     */
    public function setCliente(\ReparacionBundle\Entity\Cliente $cliente = null)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \ReparacionBundle\Entity\Cliente
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Solicitud
     */
    public function setClienteString($cliente)
    {
        $this->clienteString = $cliente;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getClienteString()
    {
        return $this->clienteString;
    }

    /**
     * Set recepcionista
     *
     * @param \ReparacionBundle\Entity\Recepcionista $recepcionista
     *
     * @return Solicitud
     */
    public function setRecepcionista(\ReparacionBundle\Entity\Recepcionista $recepcionista = null)
    {
        $this->recepcionista = $recepcionista;

        return $this;
    }

    /**
     * Get recepcionista
     *
     * @return \ReparacionBundle\Entity\Recepcionista
     */
    public function getRecepcionista()
    {
        return $this->recepcionista;
    }
}
