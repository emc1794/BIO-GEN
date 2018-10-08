<?php

namespace ReparacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JefeTecnico
 *
 * @ORM\Table(name="jefe_tecnico")
 * @ORM\Entity(repositoryClass="ReparacionBundle\Repository\JefeTecnicoRepository")
 */
class JefeTecnico extends Persona
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
     * @ORM\OneToMany(targetEntity="Asignacion", mappedBy="asignador")
     */
    private $asignacion;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return Parent::getId();
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->asignacion = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add asignacion
     *
     * @param \ReparacionBundle\Entity\Asignacion $asignacion
     *
     * @return JefeTecnico
     */
    public function addAsignacion(\ReparacionBundle\Entity\Asignacion $asignacion)
    {
        $this->asignacion[] = $asignacion;

        return $this;
    }

    /**
     * Remove asignacion
     *
     * @param \ReparacionBundle\Entity\Asignacion $asignacion
     */
    public function removeAsignacion(\ReparacionBundle\Entity\Asignacion $asignacion)
    {
        $this->asignacion->removeElement($asignacion);
    }

    /**
     * Get asignacion
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAsignacion()
    {
        return $this->asignacion;
    }
}
