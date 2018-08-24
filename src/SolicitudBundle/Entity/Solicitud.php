<?php

namespace SolicitudBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Solicitud
 *
 * @ORM\Table(name="solicitud")
 * @ORM\Entity(repositoryClass="SolicitudBundle\Repository\SolicitudRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Solicitud
{
    public function __construct() {
        $this->solicitudDetalles = new ArrayCollection();
        $this->laboratorios = new ArrayCollection();
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
     * @var string
     *
     * @ORM\Column(name="nombrePaciente", type="string", length=100)
     */
    private $nombrePaciente;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaRegistro", type="datetime")
     */
    private $fechaRegistro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaEnvio", type="datetime" , nullable=true)
     */
    private $fechaEnvio;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=1)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="string", length=255, nullable=true)
     */
    private $observacion;

    /**
     * One Solicitud has Many SolicitudDetalles.
     * @ORM\OneToMany(targetEntity="DetalleSolicitud", mappedBy="solicitud",cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $solicitudDetalles;

    private $laboratorios;

    /**
     * @ORM\PrePersist
     */
    public function prePresist()
    {
        $this->estado='B';
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
     * Set nombrePaciente
     *
     * @param string $nombrePaciente
     *
     * @return Solicitud
     */
    public function setNombrePaciente($nombrePaciente)
    {
        $this->nombrePaciente = $nombrePaciente;

        return $this;
    }

    /**
     * Get nombrePaciente
     *
     * @return string
     */
    public function getNombrePaciente()
    {
        return $this->nombrePaciente;
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

    /**
     * Set fechaEnvio
     *
     * @param \DateTime $fechaEnvio
     *
     * @return Solicitud
     */
    public function setFechaEnvio($fechaEnvio)
    {
        $this->fechaEnvio = $fechaEnvio;

        return $this;
    }

    /**
     * Get fechaEnvio
     *
     * @return \DateTime
     */
    public function getFechaEnvio()
    {
        return $this->fechaEnvio;
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
     * @param \SolicitudBundle\Entity\DetalleSolicitud $solicitudDetalle
     *
     * @return Solicitud
     */
    public function addSolicitudDetalle(\SolicitudBundle\Entity\DetalleSolicitud $solicitudDetalle)
    {
        $this->solicitudDetalles[] = $solicitudDetalle;

        return $this;
    }

    /**
     * Remove solicitudDetalle
     *
     * @param \SolicitudBundle\Entity\DetalleSolicitud $solicitudDetalle
     */
    public function removeSolicitudDetalle(\SolicitudBundle\Entity\DetalleSolicitud $solicitudDetalle)
    {
        $solicitudDetalle->setSolicitud(null);
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
     * Add Laboratorio
     *
     * @param \SolicitudBundle\Entity\Laboratorio $laboratorio
     *
     * @return Solicitud
     */
    public function addlaboratorio(\SolicitudBundle\Entity\Laboratorio $laboratorio)
    {
        if (!$this->siExisteDetalle($laboratorio)) {
            $detalleNuevo=new DetalleSolicitud();
            $detalleNuevo->setLaboratorio($laboratorio);
            $detalleNuevo->setSolicitud($this);
            $this->addSolicitudDetalle($detalleNuevo);
            $this->laboratorios[] = $laboratorio;
        }

        return $this;
    }


    /**
     * Remove Laboratorio
     *
     * @param \SolicitudBundle\Entity\Laboratorio $laboratorio
     */
    public function removeLaboratorio(\SolicitudBundle\Entity\Laboratorio $laboratorio)
    {
        if ($this->siExisteDetalle($laboratorio)) {
            $this->removeSolicitudDetalle($this->siExisteDetalle($laboratorio));
        }
        //dump($this->getSolicitudDetalles());die();
        unset($this->laboratorios[array_search($laboratorio,$this->laboratorios)]);
    }

    /**
     * Get Laboratorio
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLaboratorio()
    {
        return $this->laboratorios;
    }

    public function siExisteDetalle($laboratorio){
        foreach ($this->solicitudDetalles as $key => $detalle) {
            if ($detalle->getLaboratorio()->getId()==$laboratorio->getId()) {
                return $detalle;
            }
        }
        return false;
    }

    public function cargarLaboratorios($laboratorio){
        $this->laboratorios[]=$laboratorio;
    }
}