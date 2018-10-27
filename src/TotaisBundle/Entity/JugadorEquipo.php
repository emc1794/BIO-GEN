<?php

namespace TotaisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JugadorEquipo
 *
 * @ORM\Table(name="jugador_equipo")
 * @ORM\Entity(repositoryClass="TotaisBundle\Repository\JugadorEquipoRepository")
 */
class JugadorEquipo
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
     * @ORM\Column(name="numero", type="integer")
     */
    private $numero;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaIngreso", type="datetime")
     */
    private $fechaIngreso;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaRetiro", type="datetime")
     */
    private $fechaRetiro;

    /**
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;
    
    /**
     * @ORM\ManyToOne(targetEntity="Jugador", inversedBy="jugadorEquipo")
     * @ORM\JoinColumn(name="jugador_id", referencedColumnName="id")
     */
    private $jugador;
    
    /**
     * @ORM\ManyToOne(targetEntity="Equipo", inversedBy="jugadorEquipo")
     * @ORM\JoinColumn(name="equipo_id", referencedColumnName="id")
     */
    private $equipo;


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
     * Set numero
     *
     * @param integer $numero
     *
     * @return JugadorEquipo
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return int
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set fechaIngreso
     *
     * @param \DateTime $fechaIngreso
     *
     * @return JugadorEquipo
     */
    public function setFechaIngreso($fechaIngreso)
    {
        $this->fechaIngreso = $fechaIngreso;

        return $this;
    }

    /**
     * Get fechaIngreso
     *
     * @return \DateTime
     */
    public function getFechaIngreso()
    {
        return $this->fechaIngreso;
    }

    /**
     * Set fechaRetiro
     *
     * @param \DateTime $fechaRetiro
     *
     * @return JugadorEquipo
     */
    public function setFechaRetiro($fechaRetiro)
    {
        $this->fechaRetiro = $fechaRetiro;

        return $this;
    }

    /**
     * Get fechaRetiro
     *
     * @return \DateTime
     */
    public function getFechaRetiro()
    {
        return $this->fechaRetiro;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return JugadorEquipo
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return bool
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set jugador
     *
     * @param \TotaisBundle\Entity\Jugador $jugador
     *
     * @return JugadorEquipo
     */
    public function setJugador(\TotaisBundle\Entity\Jugador $jugador = null)
    {
        $this->jugador = $jugador;

        return $this;
    }

    /**
     * Get jugador
     *
     * @return \TotaisBundle\Entity\Jugador
     */
    public function getJugador()
    {
        return $this->jugador;
    }

    /**
     * Set equipo
     *
     * @param \TotaisBundle\Entity\Equipo $equipo
     *
     * @return JugadorEquipo
     */
    public function setEquipo(\TotaisBundle\Entity\Equipo $equipo = null)
    {
        $this->equipo = $equipo;

        return $this;
    }

    /**
     * Get equipo
     *
     * @return \TotaisBundle\Entity\Equipo
     */
    public function getEquipo()
    {
        return $this->equipo;
    }
}
