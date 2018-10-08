<?php

namespace ReparacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recepcionista
 *
 * @ORM\Table(name="recepcionista")
 * @ORM\Entity(repositoryClass="ReparacionBundle\Repository\RecepcionistaRepository")
 */
class Recepcionista extends Persona
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
     * @ORM\OneToMany(targetEntity="Solicitud", mappedBy="recepcionista",cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $solicitud;

    /**
     * @ORM\OneToOne(targetEntity="Caja", mappedBy="recepcionista")
     */
    private $caja;


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
        $this->solicitud = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add solicitud
     *
     * @param \ReparacionBundle\Entity\Solicitud $solicitud
     *
     * @return Recepcionista
     */
    public function addSolicitud(\ReparacionBundle\Entity\Solicitud $solicitud)
    {
        $this->solicitud[] = $solicitud;

        return $this;
    }

    /**
     * Remove solicitud
     *
     * @param \ReparacionBundle\Entity\Solicitud $solicitud
     */
    public function removeSolicitud(\ReparacionBundle\Entity\Solicitud $solicitud)
    {
        $this->solicitud->removeElement($solicitud);
    }

    /**
     * Get solicitud
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSolicitud()
    {
        return $this->solicitud;
    }
}
