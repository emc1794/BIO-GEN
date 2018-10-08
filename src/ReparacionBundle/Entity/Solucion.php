<?php

namespace ReparacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Solucion
 *
 * @ORM\Table(name="solucion")
 * @ORM\Entity(repositoryClass="ReparacionBundle\Repository\SolucionRepository")
 */
class Solucion
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
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=1)
     */
    private $estado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaRegistro", type="datetime")
     */
    private $fechaRegistro;

    /**
     * @var string
     *
     * @ORM\Column(name="monto", type="decimal", precision=10, scale=2)
     */
    private $monto;

    /**
     * @ORM\OneToOne(targetEntity="Entrega", mappedBy="solucion")
     */
    private $entrega;

    /**
     * @ORM\OneToOne(targetEntity="Pago", mappedBy="solucion")
     */
    private $pago;

    /**
     * @ORM\OneToOne(targetEntity="Asignacion", inversedBy="solucion")
     * @ORM\JoinColumn(name="asignacion_id", referencedColumnName="id")
     */
    private $asignacion;

    /**
     * @ORM\OneToMany(targetEntity="DetalleRepuesto", mappedBy="solucion",cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $detalleRepuesto;


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
     * @return Solucion
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
     * Set estado
     *
     * @param string $estado
     *
     * @return Solucion
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     *
     * @return Solucion
     */
    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    /**
     * Get fechaRegistro
     *
     * @return \DateTime
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * Set monto
     *
     * @param string $monto
     *
     * @return Solucion
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->detalleRepuesto = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set entrega
     *
     * @param \ReparacionBundle\Entity\Entrega $entrega
     *
     * @return Solucion
     */
    public function setEntrega(\ReparacionBundle\Entity\Entrega $entrega = null)
    {
        $this->entrega = $entrega;

        return $this;
    }

    /**
     * Get entrega
     *
     * @return \ReparacionBundle\Entity\Entrega
     */
    public function getEntrega()
    {
        return $this->entrega;
    }

    /**
     * Set pago
     *
     * @param \ReparacionBundle\Entity\Pago $pago
     *
     * @return Solucion
     */
    public function setPago(\ReparacionBundle\Entity\Pago $pago = null)
    {
        $this->pago = $pago;

        return $this;
    }

    /**
     * Get pago
     *
     * @return \ReparacionBundle\Entity\Pago
     */
    public function getPago()
    {
        return $this->pago;
    }

    /**
     * Set asignacion
     *
     * @param \ReparacionBundle\Entity\Asignacion $asignacion
     *
     * @return Solucion
     */
    public function setAsignacion(\ReparacionBundle\Entity\Asignacion $asignacion = null)
    {
        $this->asignacion = $asignacion;

        return $this;
    }

    /**
     * Get asignacion
     *
     * @return \ReparacionBundle\Entity\Asignacion
     */
    public function getAsignacion()
    {
        return $this->asignacion;
    }

    /**
     * Add detalleRepuesto
     *
     * @param \ReparacionBundle\Entity\DetalleRepuesto $detalleRepuesto
     *
     * @return Solucion
     */
    public function addDetalleRepuesto(\ReparacionBundle\Entity\DetalleRepuesto $detalleRepuesto)
    {
        $this->detalleRepuesto[] = $detalleRepuesto;

        return $this;
    }

    /**
     * Remove detalleRepuesto
     *
     * @param \ReparacionBundle\Entity\DetalleRepuesto $detalleRepuesto
     */
    public function removeDetalleRepuesto(\ReparacionBundle\Entity\DetalleRepuesto $detalleRepuesto)
    {
        $this->detalleRepuesto->removeElement($detalleRepuesto);
    }

    /**
     * Get detalleRepuesto
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDetalleRepuesto()
    {
        return $this->detalleRepuesto;
    }
}
