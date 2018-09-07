<?php

namespace SolicitudBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Persona
 *
 * @ORM\Table(name="persona")
 * @ORM\InheritanceType("JOINED")
 * @ORM\Entity(repositoryClass="SolicitudBundle\Repository\PersonaRepository")
 * @UniqueEntity(
 *     fields={"ci"},
 *     errorPath="ci",
 *     message="Este Carnet de identidad ya existe"
 * )
 */
class Persona
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
     * @ORM\Column(name="nombre", type="string", length=40)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="paterno", type="string", length=50)
     */
    private $paterno;

    /**
     * @var string
     *
     * @ORM\Column(name="materno", type="string", length=50)
     */
    private $materno;

    /**
     * @var string
     *
     * @ORM\Column(name="ci", type="string", length=10, unique=true)
     */
    private $ci;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaNacimiento", type="date")
     */
    private $fechaNacimiento;

    /**
     * @var bool
     *
     * @ORM\Column(name="sexo", type="boolean")
     */
    private $sexo;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=10, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=60, nullable=true)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=30, nullable=true, unique=true)
     */
    private $email;

    /**
     * una persona tiene un usuario
     * @ORM\OneToOne(targetEntity="Usuario", mappedBy="persona")
     */
    private $usuario;

    public function getNombreCompleto(){
        return $this->getPaterno().' '.$this->getMaterno().' '.$this->getNombre();
    }


    /**
     * Get id
     *
     * @return int
     */
    protected function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Persona
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
     * Set paterno
     *
     * @param string $paterno
     *
     * @return Persona
     */
    public function setPaterno($paterno)
    {
        $this->paterno = $paterno;

        return $this;
    }

    /**
     * Get paterno
     *
     * @return string
     */
    public function getPaterno()
    {
        return $this->paterno;
    }

    /**
     * Set materno
     *
     * @param string $materno
     *
     * @return Persona
     */
    public function setMaterno($materno)
    {
        $this->materno = $materno;

        return $this;
    }

    /**
     * Get materno
     *
     * @return string
     */
    public function getMaterno()
    {
        return $this->materno;
    }

    /**
     * Set ci
     *
     * @param string $ci
     *
     * @return Persona
     */
    public function setCi($ci)
    {
        $this->ci = $ci;

        return $this;
    }

    /**
     * Get ci
     *
     * @return string
     */
    public function getCi()
    {
        return $this->ci;
    }

    /**
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     *
     * @return Persona
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get fechaNacimiento
     *
     * @return \DateTime
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    public function getFechaNacimientoString()
    {
        return (is_null($this->fechaNacimiento))?'':$this->fechaNacimiento->format('d-m-Y h:m');
    }

    /**
     * Set sexo
     *
     * @param boolean $sexo
     *
     * @return Persona
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return bool
     */
    public function getSexo()
    {
        return $this->sexo;
    }

     public function getSexoString()
    {
        if ($this->sexo) {
            return 'Masculino';
        }else{
            return 'Femenino';
        }
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Persona
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Persona
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Persona
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set usuario
     *
     * @param \SolicitudBundle\Entity\Usuario $usuario
     *
     * @return Persona
     */
    public function setUsuario(\SolicitudBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \SolicitudBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
