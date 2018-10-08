<?php

namespace ReparacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Caja
 *
 * @ORM\Table(name="caja")
 * @ORM\Entity(repositoryClass="ReparacionBundle\Repository\CajaRepository")
 */
class Caja
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
     * @ORM\Column(name="descripcion", type="string", length=50, unique=true)
     */
    private $descripcion;

    /**
     * @ORM\OneToOne(targetEntity="Recepcionista", inversedBy="caja")
     * @ORM\JoinColumn(name="recepcionista_id", referencedColumnName="id")
     */
    private $recepcionista;

    /**
     * @ORM\OneToMany(targetEntity="Pago", mappedBy="caja",)
     */
    private $pago;


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
     * @return Caja
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
}

