<?php

namespace ReparacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cliente
 *
 * @ORM\Table(name="cliente")
 * @ORM\Entity(repositoryClass="ReparacionBundle\Repository\ClienteRepository")
 */
class Cliente extends Persona
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
     * @ORM\OneToMany(targetEntity="Solicitud", mappedBy="cliente",cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $solicitud;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return Parent::getId();
    }
}

