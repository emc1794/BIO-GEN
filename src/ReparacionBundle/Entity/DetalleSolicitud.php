<?php

namespace ReparacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetalleSolicitud
 *
 * @ORM\Table(name="detalle_solicitud")
 * @ORM\Entity(repositoryClass="ReparacionBundle\Repository\DetalleSolicitudRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class DetalleSolicitud
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
     * @ORM\Column(name="descripcion", type="string", length=100, nullable=false)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="string", length=255,nullable=false)
     */
    private $observacion;

    /**
     * @var string
     *
     * @ORM\Column(name="serie", type="string", length=50, nullable=false)
     */
    private $serie;


    /**
     * Many detalles have One laboratorio.
     * @ORM\ManyToOne(targetEntity="Artefacto", inversedBy="solicitudDetalles" )
     * @ORM\JoinColumn(name="artefacto_id", referencedColumnName="id", nullable=false)
     */
    private $artefacto;

    /**
     * Many detalles have One solicitud.
     * @ORM\ManyToOne(targetEntity="Solicitud", inversedBy="solicitudDetalles")
     * @ORM\JoinColumn(name="solicitud_id", referencedColumnName="id")
     */
    private $solicitud;

    /**
     * One Solicitud has Many SolicitudDetalles.
     * @ORM\OneToOne(targetEntity="Asignacion", mappedBy="detalleSolicitud",cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $asignacion;

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
     * @return DetalleSolicitud
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
     * Set estado
     *
     * @param string $estado
     *
     * @return DetalleSolicitud
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return DetalleSolicitud
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set serie
     *
     * @param string $serie
     *
     * @return DetalleSolicitud
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;

        return $this;
    }

    /**
     * Get serie
     *
     * @return string
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Set artefacto
     *
     * @param \ReparacionBundle\Entity\Artefacto $artefacto
     *
     * @return DetalleSolicitud
     */
    public function setArtefacto(\ReparacionBundle\Entity\Artefacto $artefacto = null)
    {
        $this->artefacto = $artefacto;

        return $this;
    }

    /**
     * Get artefacto
     *
     * @return \ReparacionBundle\Entity\Artefacto
     */
    public function getArtefacto()
    {
        return $this->artefacto;
    }

    /**
     * Set solicitud
     *
     * @param \ReparacionBundle\Entity\Solicitud $solicitud
     *
     * @return DetalleSolicitud
     */
    public function setSolicitud(\ReparacionBundle\Entity\Solicitud $solicitud = null)
    {
        $this->solicitud = $solicitud;

        return $this;
    }

    /**
     * Get solicitud
     *
     * @return \ReparacionBundle\Entity\Solicitud
     */
    public function getSolicitud()
    {
        return $this->solicitud;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     *
     * @return DetalleSolicitud
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
     * Set asignacion
     *
     * @param \ReparacionBundle\Entity\Asignacion $asignacion
     *
     * @return DetalleSolicitud
     */
    public function setAsignacion(\ReparacionBundle\Entity\Asignacion $asignacion = null)
    {
        $this->asignacion = $asignacion;

        return $this;
    }

    /**
     * Get asignacion
     *
     * @return \ReparacionBundle\Entity\Asignacion
     */
    public function getAsignacion()
    {
        return $this->asignacion;
    }
}
