<?php

namespace TotaisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representante
 *
 * @ORM\Table(name="representante")
 * @ORM\Entity(repositoryClass="TotaisBundle\Repository\RepresentanteRepository")
 */
class Representante extends Persona
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
     * One Solicitud has Many SolicitudDetalles.
     * @ORM\OneToMany(targetEntity="Equipo", mappedBy="representante",cascade={"persist", "remove"}, orphanRemoval=true)
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
     * Add equipo
     *
     * @param \TotaisBundle\Entity\Equipo $equipo
     *
     * @return Representante
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
