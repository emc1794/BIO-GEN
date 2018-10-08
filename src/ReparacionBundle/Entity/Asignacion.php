<?php

namespace ReparacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Asignacion
 *
 * @ORM\Table(name="asignacion")
 * @ORM\Entity(repositoryClass="ReparacionBundle\Repository\AsignacionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Asignacion
{
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
     * @ORM\Column(name="fecha_plazo", type="date")
     * @Assert\GreaterThanOrEqual("today")
     */
    private $fechaPlazo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaRegistro", type="date")
     */
    private $fechaRegistro;

    /**
     * Many detalles have One solicitud.
     * @ORM\ManyToOne(targetEntity="JefeTecnico", inversedBy="asignacion")
     * @ORM\JoinColumn(name="asignador_id", referencedColumnName="id")
     */
    private $asignador;

    /**
     * Many detalles have One solicitud.
     * @ORM\ManyToOne(targetEntity="Tecnico", inversedBy="asignacion")
     * @ORM\JoinColumn(name="asignado_id", referencedColumnName="id")
     */
    private $asignado;

    /**
     * @ORM\OneToOne(targetEntity="Solucion", mappedBy="asignacion")
     */
    private $solucion;

    /**
     * Many detalles have One solicitud.
     * @ORM\OneToOne(targetEntity="DetalleSolicitud", inversedBy="asignacion")
     * @ORM\JoinColumn(name="detalle_solicitud_id", referencedColumnName="id")
     */
    private $detalleSolicitud;

    private $tecnicoId;

    /**
     * @ORM\PrePersist
     */
    public function prePresist()
    {
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
     * Set fechaPlazo
     *
     * @param \DateTime $fechaPlazo
     *
     * @return Asignacion
     */
    public function setFechaPlazo($fechaPlazo)
    {
        $this->fechaPlazo = $fechaPlazo;

        return $this;
    }

    /**
     * Get fechaPlazo
     *
     * @return \DateTime
     */
    public function getFechaPlazo()
    {
        return $this->fechaPlazo;
    }

    public function getFechaPlazoString()
    {
        return (is_null($this->fechaPlazo))?'':$this->fechaPlazo->format('d-m-Y h:m');
    }

    /**
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     *
     * @return Asignacion
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
     * Set asignador
     *
     * @param \ReparacionBundle\Entity\JefeTecnico $asignador
     *
     * @return Asignacion
     */
    public function setAsignador(\ReparacionBundle\Entity\JefeTecnico $asignador = null)
    {
        $this->asignador = $asignador;

        return $this;
    }

    /**
     * Get asignador
     *
     * @return \ReparacionBundle\Entity\JefeTecnico
     */
    public function getAsignador()
    {
        return $this->asignador;
    }

    /**
     * Set asignado
     *
     * @param \ReparacionBundle\Entity\Tecnico $asignado
     *
     * @return Asignacion
     */
    public function setAsignado(\ReparacionBundle\Entity\Tecnico $asignado = null)
    {
        $this->asignado = $asignado;

        return $this;
    }

    /**
     * Get asignado
     *
     * @return \ReparacionBundle\Entity\Tecnico
     */
    public function getAsignado()
    {
        return $this->asignado;
    }

    /**
     * Set detalleSolicitud
     *
     * @param \ReparacionBundle\Entity\DetalleSolicitud $detalleSolicitud
     *
     * @return Asignacion
     */
    public function setDetalleSolicitud(\ReparacionBundle\Entity\DetalleSolicitud $detalleSolicitud = null)
    {
        $this->detalleSolicitud = $detalleSolicitud;

        return $this;
    }

    /**
     * Get detalleSolicitud
     *
     * @return \ReparacionBundle\Entity\DetalleSolicitud
     */
    public function getDetalleSolicitud()
    {
        return $this->detalleSolicitud;
    }

    /**
     * Set solucion
     *
     * @param \ReparacionBundle\Entity\Solucion $solucion
     *
     * @return Asignacion
     */
    public function setSolucion(\ReparacionBundle\Entity\Solucion $solucion = null)
    {
        $this->solucion = $solucion;

        return $this;
    }

    /**
     * Get solucion
     *
     * @return \ReparacionBundle\Entity\Solucion
     */
    public function getSolucion()
    {
        return $this->solucion;
    }

    public function getTecnicoId()
    {
        return $this->tecnicoId;
    }

    public function setTecnicoId($tecnicoId)
    {
        $this->tecnicoId=$tecnicoId;
        return $this;
    }
}
