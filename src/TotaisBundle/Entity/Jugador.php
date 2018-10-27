<?php

namespace TotaisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jugador
 *
 * @ORM\Table(name="jugador")
 * @ORM\Entity(repositoryClass="TotaisBundle\Repository\JugadorRepository")
 */
class Jugador extends Persona
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
     * @ORM\OneToMany(targetEntity="JugadorEquipo", mappedBy="jugador",cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $jugadorEquipo;


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
        $this->jugadorEquipo = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add jugadorEquipo
     *
     * @param \TotaisBundle\Entity\JugadorEquipo $jugadorEquipo
     *
     * @return Jugador
     */
    public function addJugadorEquipo(\TotaisBundle\Entity\JugadorEquipo $jugadorEquipo)
    {
        $this->jugadorEquipo[] = $jugadorEquipo;

        return $this;
    }

    /**
     * Remove jugadorEquipo
     *
     * @param \TotaisBundle\Entity\JugadorEquipo $jugadorEquipo
     */
    public function removeJugadorEquipo(\TotaisBundle\Entity\JugadorEquipo $jugadorEquipo)
    {
        $this->jugadorEquipo->removeElement($jugadorEquipo);
    }

    /**
     * Get jugadorEquipo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getJugadorEquipo()
    {
        return $this->jugadorEquipo;
    }
}
