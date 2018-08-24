<?php

namespace SolicitudBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Categoria
 *
 * @ORM\Table(name="categoria")
 * @ORM\Entity(repositoryClass="SolicitudBundle\Repository\CategoriaRepository")
 */
class Categoria
{

    public function __construct() {
        $this->laboratorios = new ArrayCollection();
    }

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
     * @ORM\Column(name="nombre", type="string", length=50, unique=true)
     */
    private $nombre;

    /**
     * One Category has Many Lab.
     * @ORM\OneToMany(targetEntity="Laboratorio", mappedBy="categoria")
     */
    private $laboratorios;


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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Categoria
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Add laboratorio
     *
     * @param \SolicitudBundle\Entity\Laboratorio $laboratorio
     *
     * @return Categoria
     */
    public function addLaboratorio(\SolicitudBundle\Entity\Laboratorio $laboratorio)
    {
        $this->laboratorios[] = $laboratorio;

        return $this;
    }

    /**
     * Remove laboratorio
     *
     * @param \SolicitudBundle\Entity\Laboratorio $laboratorio
     */
    public function removeLaboratorio(\SolicitudBundle\Entity\Laboratorio $laboratorio)
    {
        $this->laboratorios->removeElement($laboratorio);
    }

    /**
     * Get laboratorios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLaboratorios()
    {
        return $this->laboratorios;
    }
}
