<?php

namespace TotaisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Equipo
 *
 * @ORM\Table(name="equipo")
 * @ORM\Entity(repositoryClass="TotaisBundle\Repository\EquipoRepository")
 * @UniqueEntity(
 *     fields={"nombre"},
 *     errorPath="nombre",
 *     message="Ya existe un equipo con este nombre"
 * )
 */
class Equipo
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
     * @ORM\Column(name="nombre", type="string", length=255, unique=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="escudo", type="string", length=255, nullable=true)
     */
    private $escudo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaFundacion", type="datetime")
     */
    private $fechaFundacion;
    
    /**
     * @ORM\ManyToOne(targetEntity="Categoria", inversedBy="equipo")
     * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id",nullable=false)
     */
    private $categoria;
    
    /**
     * @ORM\ManyToOne(targetEntity="Representante", inversedBy="equipo")
     * @ORM\JoinColumn(name="representante_id", referencedColumnName="id",nullable=false)
     */
    private $representante;
    
    /**
     * @ORM\ManyToOne(targetEntity="Empleado", inversedBy="equipo")
     * @ORM\JoinColumn(name="empleado_id", referencedColumnName="id")
     */
    private $empleado;
    
    /**
     * One Solicitud has Many SolicitudDetalles.
     * @ORM\OneToMany(targetEntity="JugadorEquipo", mappedBy="equipo",cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $jugadorEquipo;


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
     * @return Equipo
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
     * Set escudo
     *
     * @param string $escudo
     *
     * @return Equipo
     */
    public function setEscudo($escudo)
    {
        $this->escudo = $escudo;

        return $this;
    }

    /**
     * Get escudo
     *
     * @return string
     */
    public function getEscudo()
    {
        return $this->escudo;
    }

    /**
     * Set fechaFundacion
     *
     * @param \DateTime $fechaFundacion
     *
     * @return Equipo
     */
    public function setFechaFundacion($fechaFundacion)
    {
        $this->fechaFundacion = $fechaFundacion;

        return $this;
    }

    /**
     * Get fechaFundacion
     *
     * @return \DateTime
     */
    public function getFechaFundacion()
    {
        return $this->fechaFundacion;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->jugadorEquipo = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set categoria
     *
     * @param \TotaisBundle\Entity\Categoria $categoria
     *
     * @return Equipo
     */
    public function setCategoria(\TotaisBundle\Entity\Categoria $categoria = null)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return \TotaisBundle\Entity\Categoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set representante
     *
     * @param \TotaisBundle\Entity\Representante $representante
     *
     * @return Equipo
     */
    public function setRepresentante(\TotaisBundle\Entity\Representante $representante = null)
    {
        $this->representante = $representante;

        return $this;
    }

    /**
     * Get representante
     *
     * @return \TotaisBundle\Entity\Representante
     */
    public function getRepresentante()
    {
        return $this->representante;
    }

    /**
     * Set empleado
     *
     * @param \TotaisBundle\Entity\Empleado $empleado
     *
     * @return Equipo
     */
    public function setEmpleado(\TotaisBundle\Entity\Empleado $empleado = null)
    {
        $this->empleado = $empleado;

        return $this;
    }

    /**
     * Get empleado
     *
     * @return \TotaisBundle\Entity\Empleado
     */
    public function getEmpleado()
    {
        return $this->empleado;
    }

    /**
     * Add jugadorEquipo
     *
     * @param \TotaisBundle\Entity\JugadorEquipo $jugadorEquipo
     *
     * @return Equipo
     */
    public function addJugadorEquipo(\TotaisBundle\Entity\JugadorEquipo $jugadorEquipo)
    {
        $this->jugadorEquipo[] = $jugadorEquipo;

        return $this;
    }

    /**
     * Remove jugadorEquipo
     *
     * @param \TotaisBundle\Entity\JugadorEquipo $jugadorEquipo
     */
    public function removeJugadorEquipo(\TotaisBundle\Entity\JugadorEquipo $jugadorEquipo)
    {
        $this->jugadorEquipo->removeElement($jugadorEquipo);
    }

    /**
     * Get jugadorEquipo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getJugadorEquipo()
    {
        return $this->jugadorEquipo;
    }
}
