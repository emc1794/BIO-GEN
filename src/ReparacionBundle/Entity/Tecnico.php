<?php

namespace ReparacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tecnico
 *
 * @ORM\Table(name="tecnico")
 * @ORM\Entity(repositoryClass="ReparacionBundle\Repository\TecnicoRepository")
 */
class Tecnico extends Persona
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
     * @ORM\OneToMany(targetEntity="Asignacion", mappedBy="asignado")
     */
    private $asignacion;

    /**
     * @ORM\ManyToOne(targetEntity="Especialidad")
     * @ORM\JoinColumn(name="especialidad_id", referencedColumnName="id",nullable=false)
     */
    private $especialidad;


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
     * @return Tecnico
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

    /**
     * Set especialidad
     *
     * @param \ReparacionBundle\Entity\Especialidad $especialidad
     *
     * @return Tecnico
     */
    public function setEspecialidad(\ReparacionBundle\Entity\Especialidad $especialidad = null)
    {
        $this->especialidad = $especialidad;

        return $this;
    }

    /**
     * Get especialidad
     *
     * @return \ReparacionBundle\Entity\Especialidad
     */
    public function getEspecialidad()
    {
        return $this->especialidad;
    }
}
