<?php

namespace ReparacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Artefacto
 *
 * @ORM\Table(name="artefacto")
 * @ORM\Entity(repositoryClass="ReparacionBundle\Repository\ArtefactoRepository")
 */
class Artefacto
{

    public function __construct() {
        $this->solicitudDetalles = new ArrayCollection();
    }
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
     * @ORM\Column(name="nombre", type="string", length=50, unique=true)
     */
    private $nombre;


    /**
     * One Laboratorio has Many SolicitudDetalles.
     * @ORM\OneToMany(targetEntity="DetalleSolicitud", mappedBy="artefacto")
     */
    private $solicitudDetalles;

    public function __toString(){
        return $this->nombre;
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Artefacto
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Add solicitudDetalle
     *
     * @param \ReparacionBundle\Entity\DetalleSolicitud $solicitudDetalle
     *
     * @return Artefacto
     */
    public function addSolicitudDetalle(\ReparacionBundle\Entity\DetalleSolicitud $solicitudDetalle)
    {
        $this->solicitudDetalles[] = $solicitudDetalle;

        return $this;
    }

    /**
     * Remove solicitudDetalle
     *
     * @param \ReparacionBundle\Entity\DetalleSolicitud $solicitudDetalle
     */
    public function removeSolicitudDetalle(\ReparacionBundle\Entity\DetalleSolicitud $solicitudDetalle)
    {
        $this->solicitudDetalles->removeElement($solicitudDetalle);
    }

    /**
     * Get solicitudDetalles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSolicitudDetalles()
    {
        return $this->solicitudDetalles;
    }
}
