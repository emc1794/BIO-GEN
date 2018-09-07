<?php

namespace SolicitudBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="usuario")
 * @ORM\Entity(repositoryClass="SolicitudBundle\Repository\UsuarioRepository")
 * @UniqueEntity(fields={"persona"}, message="Esta persona ya existe...")
 * @UniqueEntity(fields="login", message="Este login esta repetido...")
 * @ORM\HasLifecycleCallbacks()
 */
class Usuario implements AdvancedUserInterface, EquatableInterface,  \Serializable {

// INICIO Metodos requerido por la interfaz UserInterface ====================================

    public function getUsername(){
        return $this->login;
    }

    public function isEqualTo(\Symfony\Component\Security\Core\User\UserInterface $usuario){
        return $this->getUsername() == $usuario->getUsername();
    }

    public function eraseCredentials(){
    }

    public function getRoles(){
        return explode('-', $this->role);
    }

    public function getSalt(){
        return false;
    }

    public function getPassword(){
        return $this->password;
    }

// Metodos requerido cuando la entidad USUARIO se relaciona con Cargo o Rol ==================

    public function serialize(){
       return serialize($this->id);
    }

    public function unserialize($data){
        $this->id = unserialize($data);
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->activo;
    }

// FIN Metodos requerido por la interfaz UserInterface =======================================

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

   /**
    * @ORM\Column(type="string", length=8, unique=true)
    * @Assert\NotBlank(message="El login no debe estar vacio...")
    * @Assert\Length(min=4, max=8)
    */
    private $login;

   /**
    * @ORM\Column(type="string", length=255, nullable=false)
    * @Assert\Length(min=5)
    */
    private $password;

    /**
    * @ORM\Column(type="string", length=30, unique=false,nullable=false)
    */
    private $role;

    /**
    * @ORM\Column(type="boolean", unique=false)
    */
    private $activo;

    /**
     * @ORM\Column(name="creadoEl", type="datetime")
     */
    private $fechaRegistro;


// === Foraneas ======================================================== //
    /**
     * un usuario tiene un  persona
     * @ORM\OneToOne(targetEntity="Persona", inversedBy="usuario")
     * @ORM\JoinColumn(name="persona_id", referencedColumnName="id")
     */
    private $persona;

// === Funciones Auxiliares ============================================ //

    public function setId($id){
        $this->id = $id;

        return $this;
    }

    public function __toString(){
        return $this->login;
    }

// === Retrollamadas =================================================== //

    /**
     * @ORM\PrePersist
     */
   public function PrePersist(){
      $this->login    = strtolower($this->login);
      $this->activo = false;
      $this->fechaRegistro = new \DateTime();
   }

    /**
     * @ORM\PreUpdate
     */
   public function PreUpdate(){
      $this->login    = strtolower($this->login);
   }

// === Gets y Sets ===================================================== //

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set login
     *
     * @param string $login
     * @return Usuario
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Usuario
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getFechaRegistroString()
    {
        return (is_null($this->fechaRegistro))?'':$this->fechaRegistro->format('d-m-Y');
    }

    /**
     * Set role
     *
     * @param string $role
     * @return Usuario
     */
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }


    public function getRoleString()
    {
        $roles=explode('-',$this->getRole());
        $roleString=array();

        foreach ($roles as $rol){
            switch ($rol)
            {
                case 'ROLE_ADM' :
                    $roleString[]='Administrador';
                    break;
                case 'ROLE_MED':
                    $roleString[]='Medico';
                    break;

            }
        }


        return implode(',',$roleString);
    }

    public function esAdmin()
    {
        $admin=false;
        $roles=explode('-',$this->getRole());
        foreach ($roles as $rol) {
            if ($rol=='ROLE_ADM'){
                $admin=true;
            }
        }

        return $admin;
    }


    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Usuario
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;
    
        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean 
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     *
     * @return Usuario
     */
    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    /**
     * Get fechaRegistro
     *
     * @return \DateTime
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * Set persona
     *
     * @param \SolicitudBundle\Entity\Persona $persona
     *
     * @return Usuario
     */
    public function setPersona(\SolicitudBundle\Entity\Persona $persona = null)
    {
        $this->persona = $persona;

        return $this;
    }

    /**
     * Get persona
     *
     * @return \SolicitudBundle\Entity\Persona
     */
    public function getPersona()
    {
        return $this->persona;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->usuario = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add usuario
     *
     * @param \SolicitudBundle\Entity\Solicitud $usuario
     *
     * @return Usuario
     */
    public function addUsuario(\SolicitudBundle\Entity\Solicitud $usuario)
    {
        $this->usuario[] = $usuario;

        return $this;
    }

    /**
     * Remove usuario
     *
     * @param \SolicitudBundle\Entity\Solicitud $usuario
     */
    public function removeUsuario(\SolicitudBundle\Entity\Solicitud $usuario)
    {
        $this->usuario->removeElement($usuario);
    }

    /**
     * Get usuario
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
