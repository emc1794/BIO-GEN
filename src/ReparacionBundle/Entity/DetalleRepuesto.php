<?php

namespace ReparacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetalleRepuesto
 *
 * @ORM\Table(name="detalle_repuesto")
 * @ORM\Entity(repositoryClass="ReparacionBundle\Repository\DetalleRepuestoRepository")
 */
class DetalleRepuesto
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
     * @var int
     *
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad;

    /**
     * @var string
     *
     * @ORM\Column(name="precio", type="decimal", precision=10, scale=2)
     */
    private $precio;

    /**
     * @ORM\ManyToOne(targetEntity="Repuesto", inversedBy="detalleRepuesto" )
     * @ORM\JoinColumn(name="repuesto_id", referencedColumnName="id", nullable=false)
     */
    private $repuesto;

    /**
     * @ORM\ManyToOne(targetEntity="Solucion", inversedBy="detalleRepuesto" )
     * @ORM\JoinColumn(name="solucion_id", referencedColumnName="id", nullable=false)
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
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return DetalleRepuesto
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return int
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set precio
     *
     * @param string $precio
     *
     * @return DetalleRepuesto
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return string
     */
    public function getPrecio()
    {
        return $this->precio;
    }
}

