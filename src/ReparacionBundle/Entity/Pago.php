<?php

namespace ReparacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pago
 *
 * @ORM\Table(name="pago")
 * @ORM\Entity(repositoryClass="ReparacionBundle\Repository\PagoRepository")
 */
class Pago
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
     * @var \DateTime
     *
     * @ORM\Column(name="fechaPago", type="datetime")
     */
    private $fechaPago;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=150)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="monto", type="decimal", precision=10, scale=2)
     */
    private $monto;

    /**
     * @ORM\OneToOne(targetEntity="Solucion", inversedBy="pago")
     * @ORM\JoinColumn(name="solucion_id", referencedColumnName="id")
     */
    private $solucion;

    /**
     * @ORM\ManyToOne(targetEntity="Caja", inversedBy="pago" )
     * @ORM\JoinColumn(name="caja_id", referencedColumnName="id", nullable=false)
     */
    private $caja;

    /**
     * @ORM\ManyToOne(targetEntity="TipoPago", inversedBy="pago" )
     * @ORM\JoinColumn(name="tipo_pago_id", referencedColumnName="id", nullable=false)
     */
    private $tipoPago;


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
     * Set fechaPago
     *
     * @param \DateTime $fechaPago
     *
     * @return Pago
     */
    public function setFechaPago($fechaPago)
    {
        $this->fechaPago = $fechaPago;

        return $this;
    }

    /**
     * Get fechaPago
     *
     * @return \DateTime
     */
    public function getFechaPago()
    {
        return $this->fechaPago;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Pago
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
     * Set monto
     *
     * @param string $monto
     *
     * @return Pago
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto
     *
     * @return string
     */
    public function getMonto()
    {
        return $this->monto;
    }
}

