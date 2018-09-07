<?php

namespace SolicitudBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Asignacion
 *
 * @ORM\Table(name="asignacion")
 * @ORM\Entity(repositoryClass="SolicitudBundle\Repository\AsignacionRepository")
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
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=1)
     */
    private $estado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * Many detalles have One solicitud.
     * @ORM\ManyToOne(targetEntity="DetalleEmpleado", inversedBy="asignador")
     * @ORM\JoinColumn(name="asignador_id", referencedColumnName="id")
     */
    private $asignador;

    /**
     * Many detalles have One solicitud.
     * @ORM\ManyToOne(targetEntity="DetalleEmpleado", inversedBy="asignado")
     * @ORM\JoinColumn(name="asignado_id", referencedColumnName="id")
     */
    private $asignado;

    /**
     * Many detalles have One solicitud.
     * @ORM\ManyToOne(targetEntity="Solicitud", inversedBy="asignacion")
     * @ORM\JoinColumn(name="solicitud_id", referencedColumnName="id")
     */
    private $solicitud;


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
     * Set estado
     *
     * @param string $estado
     *
     * @return Asignacion
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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Asignacion
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }
}

