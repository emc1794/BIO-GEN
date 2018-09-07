<?php

namespace SolicitudBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MedicoCentro
 *
 * @ORM\Table(name="medico_centro")
 * @ORM\Entity(repositoryClass="SolicitudBundle\Repository\MedicoCentroRepository")
 */
class MedicoCentro
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
     * Many detalles have One solicitud.
     * @ORM\ManyToOne(targetEntity="Medico", inversedBy="medicoCentro")
     * @ORM\JoinColumn(name="medico_id", referencedColumnName="id")
     */
    private $medico;

    /**
     * Many detalles have One solicitud.
     * @ORM\ManyToOne(targetEntity="Centro", inversedBy="medicoCentro")
     * @ORM\JoinColumn(name="centro_id", referencedColumnName="id")
     */
    private $centro;

    /**
     * One Solicitud has Many SolicitudDetalles.
     * @ORM\ManyToMany(targetEntity="Especialidad", inversedBy="medicoCentro")
     * @ORM\JoinTable(name="detalle_especialidad")
     */
    private $especialidad;

    /**
     * One Solicitud has Many SolicitudDetalles.
     * @ORM\OneToMany(targetEntity="Solicitud", mappedBy="medico",cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $solicitud;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

