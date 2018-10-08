<?php

namespace ReparacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoPago
 *
 * @ORM\Table(name="tipo_pago")
 * @ORM\Entity(repositoryClass="ReparacionBundle\Repository\TipoPagoRepository")
 */
class TipoPago
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
     * @ORM\Column(name="formaPago", type="string", length=60, unique=true)
     */
    private $formaPago;

    /**
     * @ORM\OneToMany(targetEntity="Pago", mappedBy="tipoPago")
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
     * Set formaPago
     *
     * @param string $formaPago
     *
     * @return TipoPago
     */
    public function setFormaPago($formaPago)
    {
        $this->formaPago = $formaPago;

        return $this;
    }

    /**
     * Get formaPago
     *
     * @return string
     */
    public function getFormaPago()
    {
        return $this->formaPago;
    }
}

