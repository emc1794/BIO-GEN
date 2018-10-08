<?php

namespace ReparacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entrega
 *
 * @ORM\Table(name="entrega")
 * @ORM\Entity(repositoryClass="ReparacionBundle\Repository\EntregaRepository")
 */
class Entrega
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
     * @ORM\Column(name="descripcion", type="string", length=100)
     */
    private $descripcion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @ORM\OneToOne(targetEntity="Solucion", inversedBy="entrega")
     * @ORM\JoinColumn(name="solucion_id", referencedColumnName="id")
     */
    private $solucion;


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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Entrega
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Entrega
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

    /**
     * Set solucion
     *
     * @param \ReparacionBundle\Entity\Solucion $solucion
     *
     * @return Entrega
     */
    public function setSolucion(\ReparacionBundle\Entity\Solucion $solucion = null)
    {
        $this->solucion = $solucion;

        return $this;
    }

    /**
     * Get solucion
     *
     * @return \ReparacionBundle\Entity\Solucion
     */
    public function getSolucion()
    {
        return $this->solucion;
    }
}
