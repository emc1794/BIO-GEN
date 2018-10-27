<?php

namespace TotaisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoEmpleado
 *
 * @ORM\Table(name="tipo_empleado")
 * @ORM\Entity(repositoryClass="TotaisBundle\Repository\TipoEmpleadoRepository")
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
    private $tipoEmpleado;
    
    /**
     * One Solicitud has Many SolicitudDetalles.
     * @ORM\OneToMany(targetEntity="Empleado", mappedBy="tipoEmpleado",cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $empleado;


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
     * Constructor
     */
    public function __construct()
    {
        $this->empleado = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set tipoEmpleado
     *
     * @param string $tipoEmpleado
     *
     * @return TipoEmpleado
     */
    public function setTipoEmpleado($tipoEmpleado)
    {
        $this->tipoEmpleado = $tipoEmpleado;

        return $this;
    }

    /**
     * Get tipoEmpleado
     *
     * @return string
     */
    public function getTipoEmpleado()
    {
        return $this->tipoEmpleado;
    }

    /**
     * Add empleado
     *
     * @param \TotaisBundle\Entity\Empleado $empleado
     *
     * @return TipoEmpleado
     */
    public function addEmpleado(\TotaisBundle\Entity\Empleado $empleado)
    {
        $this->empleado[] = $empleado;

        return $this;
    }

    /**
     * Remove empleado
     *
     * @param \TotaisBundle\Entity\Empleado $empleado
     */
    public function removeEmpleado(\TotaisBundle\Entity\Empleado $empleado)
    {
        $this->empleado->removeElement($empleado);
    }

    /**
     * Get empleado
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmpleado()
    {
        return $this->empleado;
    }
}
