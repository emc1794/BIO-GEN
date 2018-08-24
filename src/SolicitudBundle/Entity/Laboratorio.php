<?php

namespace SolicitudBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Laboratorio
 *
 * @ORM\Table(name="laboratorio")
 * @ORM\Entity(repositoryClass="SolicitudBundle\Repository\LaboratorioRepository")
 */
class Laboratorio
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
     * @ORM\Column(name="nombre", type="string", length=30, unique=true)
     */
    private $nombre;

    /**
     * Many Lab have One Category.
     * @ORM\ManyToOne(targetEntity="Categoria", inversedBy="laboratorios")
     * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     */
    private $categoria;

    /**
     * One Laboratorio has Many SolicitudDetalles.
     * @ORM\OneToMany(targetEntity="DetalleSolicitud", mappedBy="laboratorio")
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
     * @return Laboratorio
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
     * Set categoria
     *
     * @param \SolicitudBundle\Entity\Categoria $categoria
     *
     * @return Laboratorio
     */
    public function setCategoria(\SolicitudBundle\Entity\Categoria $categoria = null)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return \SolicitudBundle\Entity\Categoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Add solicitudDetalle
     *
     * @param \SolicitudBundle\Entity\DetalleSolicitud $solicitudDetalle
     *
     * @return Laboratorio
     */
    public function addSolicitudDetalle(\SolicitudBundle\Entity\DetalleSolicitud $solicitudDetalle)
    {
        $this->solicitudDetalles[] = $solicitudDetalle;

        return $this;
    }

    /**
     * Remove solicitudDetalle
     *
     * @param \SolicitudBundle\Entity\DetalleSolicitud $solicitudDetalle
     */
    public function removeSolicitudDetalle(\SolicitudBundle\Entity\DetalleSolicitud $solicitudDetalle)
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
