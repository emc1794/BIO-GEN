<?php

namespace SolicitudBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoEmpleado
 *
 * @ORM\Table(name="tipo_empleado")
 * @ORM\Entity(repositoryClass="SolicitudBundle\Repository\TipoEmpleadoRepository")
 */
class TipoEmpleado
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
     * @ORM\Column(name="cargo", type="string", length=100)
     */
    private $cargo;

    /**
     * One Solicitud has Many SolicitudDetalles.
     * @ORM\OneToMany(targetEntity="DetalleEmpleado", mappedBy="tipoEmpleado",cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $detalleEmpleado;


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
     * Set cargo
     *
     * @param string $cargo
     *
     * @return TipoEmpleado
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get cargo
     *
     * @return string
     */
    public function getCargo()
    {
        return $this->cargo;
    }
}

