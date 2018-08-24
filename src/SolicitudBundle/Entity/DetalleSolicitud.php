<?php

namespace SolicitudBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetalleSolicitud
 *
 * @ORM\Table(name="detalle_solicitud")
 * @ORM\Entity(repositoryClass="SolicitudBundle\Repository\DetalleSolicitudRepository")
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
     * @ORM\Column(name="observacion", type="string", length=100, nullable=true)
     */
    private $observacion;

    /**
     * @var string
     *
     * @ORM\Column(name="resultado", type="string", length=255, nullable=true)
     */
    private $resultado;

    /**
     * Many detalles have One laboratorio.
     * @ORM\ManyToOne(targetEntity="Laboratorio", inversedBy="solicitudDetalles")
     * @ORM\JoinColumn(name="laboratorio_id", referencedColumnName="id")
     */
    private $laboratorio;

    /**
     * Many detalles have One solicitud.
     * @ORM\ManyToOne(targetEntity="Solicitud", inversedBy="solicitudDetalles")
     * @ORM\JoinColumn(name="solicitud_id", referencedColumnName="id")
     */
    private $solicitud;

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
     * Set resultado
     *
     * @param string $resultado
     *
     * @return DetalleSolicitud
     */
    public function setResultado($resultado)
    {
        $this->resultado = $resultado;

        return $this;
    }

    /**
     * Get resultado
     *
     * @return string
     */
    public function getResultado()
    {
        return $this->resultado;
    }

    /**
     * Set laboratorio
     *
     * @param \SolicitudBundle\Entity\Laboratorio $laboratorio
     *
     * @return DetalleSolicitud
     */
    public function setLaboratorio(\SolicitudBundle\Entity\Laboratorio $laboratorio = null)
    {
        $this->laboratorio = $laboratorio;

        return $this;
    }

    /**
     * Get laboratorio
     *
     * @return \SolicitudBundle\Entity\Laboratorio
     */
    public function getLaboratorio()
    {
        return $this->laboratorio;
    }

    /**
     * Set solicitud
     *
     * @param \SolicitudBundle\Entity\Solicitud $solicitud
     *
     * @return DetalleSolicitud
     */
    public function setSolicitud(\SolicitudBundle\Entity\Solicitud $solicitud = null)
    {
        $this->solicitud = $solicitud;

        return $this;
    }

    /**
     * Get solicitud
     *
     * @return \SolicitudBundle\Entity\Solicitud
     */
    public function getSolicitud()
    {
        return $this->solicitud;
    }
}
