<?php

// check: https://symfony.com/doc/3.4/security/entity_provider.html
// many-tomany: https://knpuniversity.com/screencast/symfony2-ep3/many-to-many-relationship
// roles: https://symfony.com/doc/3.4/security.html (seccion 2)
// Tambien hay codigo twig para verificar roles
// "{% if is_granted('ROLE_ADMIN') %}"

// IMPORTANTE: php bin/console doctrine:schema:update --force                     

// Julian was here and based his work on the fucking documentation

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use AppBundle\Entity\Role;


/**
 * User
 *
 * @ORM\Table(name="usuario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable{
    /**
     * @var int
     *
     * @ORM\Column(name="id_usuario", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=255)
     */
    private $surname;

    /**
     * @var bool
     *
     * @ORM\Column(name="eliminado", type="boolean")
     */
    private $deleted;

   /**
    * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Role")
    *   @ORM\JoinTable(
    *      name="usuario_tiene_rol",
    *      joinColumns={@ORM\JoinColumn(name="id_usuario",
    *      referencedColumnName="id_usuario")},
    *      inverseJoinColumns={@ORM\JoinColumn(name="id_rol",
    *      referencedColumnName="id_rol")},
    )}
    * )
    */
    protected $roles;


    public function __construct() {
        $this->roles = new ArrayCollection();
    }

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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
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
     * Set activo
     *
     * @param boolean $active
     *
     * @return User
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set nombre
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set apellido
     *
     * @param string $surname
     *
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set eliminado
     *
     * @param boolean $deleted
     *
     * @return User
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get eliminado
     *
     * @return bool
     */
    public function getDeleted()
    {
        return $this->deleted;
    }


    // Metodos necesario por implementar las interfaces

    public function getSalt(){
        return null;
    }

    public function getRoles(){  
        $array=array();
        foreach ($this->roles as $rol) {
            array_push($array,$rol->getName());
        }
        return $array;  
    }

     public function getRawRoles(){  
        $array=array();
        foreach ($this->roles as $rol) {
            array_push($array,$rol);
        }
        return $array; 
    }

    public function setRoles($roles){
        $this->roles=$roles;
        return $this;
    }

    public function eraseCredentials()
    {
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
        ) = unserialize($serialized, ['allowed_classes' => false]);
    }

    public function removeRole($role){
        return $this->roles->removeElement($role);
    }
}

