<?php

namespace SolicitudBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Medico
 *
 * @ORM\Table(name="medico")
 * @ORM\Entity(repositoryClass="SolicitudBundle\Repository\MedicoRepository")
 */
class Medico extends Persona
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
     * @ORM\OneToMany(targetEntity="MedicoCEntro", mappedBy="medico",cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $medicoCentro;


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
     * Constructor
     */
    public function __construct()
    {
        $this->medicoCentro = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add medicoCentro
     *
     * @param \SolicitudBundle\Entity\MedicoCEntro $medicoCentro
     *
     * @return Medico
     */
    public function addMedicoCentro(\SolicitudBundle\Entity\MedicoCEntro $medicoCentro)
    {
        $this->medicoCentro[] = $medicoCentro;

        return $this;
    }

    /**
     * Remove medicoCentro
     *
     * @param \SolicitudBundle\Entity\MedicoCEntro $medicoCentro
     */
    public function removeMedicoCentro(\SolicitudBundle\Entity\MedicoCEntro $medicoCentro)
    {
        $this->medicoCentro->removeElement($medicoCentro);
    }

    /**
     * Get medicoCentro
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMedicoCentro()
    {
        return $this->medicoCentro;
    }
}
