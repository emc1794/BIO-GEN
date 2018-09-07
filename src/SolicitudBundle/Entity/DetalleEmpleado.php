<?php

namespace SolicitudBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetalleEmpleado
 *
 * @ORM\Table(name="detalle_empleado")
 * @ORM\Entity(repositoryClass="SolicitudBundle\Repository\DetalleEmpleadoRepository")
 */
class DetalleEmpleado
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
     * @ORM\Column(name="fechaInicio", type="date")
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaFin", type="datetime")
     */
    private $fechaFin;

    /**
     * Many detalles have One solicitud.
     * @ORM\ManyToOne(targetEntity="Empleado", inversedBy="detalleEmpleado")
     * @ORM\JoinColumn(name="empleado_id", referencedColumnName="id")
     */
    private $empleado;

    /**
     * Many detalles have One solicitud.
     * @ORM\ManyToOne(targetEntity="TipoEmpleado", inversedBy="detalleEmpleado")
     * @ORM\JoinColumn(name="tipo_empleado_id", referencedColumnName="id")
     */
    private $tipoEmpleado;

    /**
     * One Solicitud has Many SolicitudDetalles.
     * @ORM\OneToMany(targetEntity="Asignacion", mappedBy="asignador",cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $asignador;

    /**
     * One Solicitud has Many SolicitudDetalles.
     * @ORM\OneToMany(targetEntity="Asignacion", mappedBy="asignado",cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $asignado;


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
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     *
     * @return DetalleEmpleado
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * Set fechaFin
     *
     * @param \DateTime $fechaFin
     *
     * @return DetalleEmpleado
     */
    public function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    /**
     * Get fechaFin
     *
     * @return \DateTime
     */
    public function getFechaFin()
    {
        return $this->fechaFin;
    }
}

