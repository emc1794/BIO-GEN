<?php

namespace TotaisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Empleado
 *
 * @ORM\Table(name="empleado")
 * @ORM\Entity(repositoryClass="TotaisBundle\Repository\EmpleadoRepository")
 */
class Empleado extends Persona
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
     * @ORM\ManyToOne(targetEntity="TipoEmpleado", inversedBy="empleado")
     * @ORM\JoinColumn(name="tipo_empleado_id", referencedColumnName="id")
     */
    private $tipoEmpleado;
    
    /**
     * One Solicitud has Many SolicitudDetalles.
     * @ORM\OneToMany(targetEntity="Equipo", mappedBy="empleado",cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $equipo;
    
    public function __toString(){
        return parent::getNombreCompleto();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return Parent::getId();
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->equipo = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set tipoEmpleado
     *
     * @param \TotaisBundle\Entity\TipoEmpleado $tipoEmpleado
     *
     * @return Empleado
     */
    public function setTipoEmpleado(\TotaisBundle\Entity\TipoEmpleado $tipoEmpleado = null)
    {
        $this->tipoEmpleado = $tipoEmpleado;

        return $this;
    }

    /**
     * Get tipoEmpleado
     *
     * @return \TotaisBundle\Entity\TipoEmpleado
     */
    public function getTipoEmpleado()
    {
        return $this->tipoEmpleado;
    }

    /**
     * Add equipo
     *
     * @param \TotaisBundle\Entity\Equipo $equipo
     *
     * @return Empleado
     */
    public function addEquipo(\TotaisBundle\Entity\Equipo $equipo)
    {
        $this->equipo[] = $equipo;

        return $this;
    }

    /**
     * Remove equipo
     *
     * @param \TotaisBundle\Entity\Equipo $equipo
     */
    public function removeEquipo(\TotaisBundle\Entity\Equipo $equipo)
    {
        $this->equipo->removeElement($equipo);
    }

    /**
     * Get equipo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEquipo()
    {
        return $this->equipo;
    }
}
