<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(fields="correoElectronico", message="El Email ya está registrado")
 */
class Usuario implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     *
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $nombre;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $apellidos;

    /**
     * @ORM\Column(type="date")
     *
     * @var \DateTime
     */
    protected $fechaNacimiento;

    /**
     * @ORM\Column(type="string", length=2, options={"fixed" = true})
     *
     * @var string
     */
    protected $sexo;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $correoElectronico;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $password;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $telefono;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     *
     * @var string
     */
    protected $ruta;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var File
     * @Assert\File(    maxSize = "2M",
     *                  mimeTypes = {"image/jpeg", "image/gif", "image/png", "image/tiff"},
     *                  maxSizeMessage = "El tamaño máximo de imágen es de 2MB.",
     *                  mimeTypesMessage = "Solo se aceptan archivos de tipo Imágen.")
     */
    protected $imagen;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean
     */
    protected $esActivo;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean
     */
    protected $esAdministrador;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean
     */
    protected $esCoordinador;

    /**
     * @ORM\OneToMany(targetEntity="Mensaje", mappedBy="usuarioOrigen")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var Mensaje
     */
    protected $mensajes;

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
     * Set nombre
     *
     * @param string $nombre
     * @return Usuario
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
     * Set apellidos
     *
     * @param string $apellidos
     * @return Usuario
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string 
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     * @return Usuario
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

    /**
     * Set correoElectronico
     *
     * @param string $correoElectronico
     * @return Usuario
     */
    public function setCorreoElectronico($correoElectronico)
    {
        $this->correoElectronico = $correoElectronico;

        return $this;
    }

    /**
     * Get correoElectronico
     *
     * @return string 
     */
    public function getCorreoElectronico()
    {
        return $this->correoElectronico;
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
     * Set telefono
     *
     * @param string $telefono
     * @return Usuario
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
     * Set esActivo
     *
     * @param boolean $esActivo
     * @return Usuario
     */
    public function setEsActivo($esActivo)
    {
        $this->esActivo = $esActivo;

        return $this;
    }

    /**
     * Get esActivo
     *
     * @return boolean 
     */
    public function getEsActivo()
    {
        return $this->esActivo;
    }

    /**
     * Set esAdministrador
     *
     * @param boolean $esAdministrador
     * @return Usuario
     */
    public function setEsAdministrador($esAdministrador)
    {
        $this->esAdministrador = $esAdministrador;

        return $this;
    }

    /**
     * Get esAdministrador
     *
     * @return boolean 
     */
    public function getEsAdministrador()
    {
        return $this->esAdministrador;
    }

    /**
     * Set esCoordinador
     *
     * @param boolean $esCoordinador
     * @return Usuario
     */
    public function setEsCoordinador($esCoordinador)
    {
        $this->esCoordinador = $esCoordinador;

        return $this;
    }

    /**
     * Get esCoordinador
     *
     * @return boolean 
     */
    public function getEsCoordinador()
    {
        return $this->esCoordinador;
    }

    /**
     *
     */
    public function __toString()
    {
        return $this->getApellidos()
        . ' ' . $this->getNombre();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->mensajes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add mensajes
     *
     * @param \AppBundle\Entity\Mensaje $mensajes
     * @return Usuario
     */
    public function addMensaje(\AppBundle\Entity\Mensaje $mensajes)
    {
        $this->mensajes[] = $mensajes;

        return $this;
    }

    /**
     * Remove mensajes
     *
     * @param \AppBundle\Entity\Mensaje $mensajes
     */
    public function removeMensaje(\AppBundle\Entity\Mensaje $mensajes)
    {
        $this->mensajes->removeElement($mensajes);
    }

    /**
     * Get mensajes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMensajes()
    {
        return $this->mensajes;
    }

    /**
     * Set sexo
     *
     * @param string $sexo
     * @return Usuario
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return string 
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return Role[] The user roles
     */
    public function getRoles()
    {
        $roles = ['ROLE_USER'];
        if ($this->getEsAdministrador()) {
            $roles[] = 'ROLE_ADMIN';
        }
        if ($this->getEsCoordinador()) {
            $roles[] = 'ROLE_COORDINADOR';
        }
        return $roles;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->getCorreoElectronico();
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
    }


    /**
     * @param string $ruta
     * @return Imagen
     */
    public function setRuta($ruta)
    {
        $this->ruta = $ruta;

        return $this;
    }

    /**
     * @return string
     */
    public function getRuta()
    {
        return $this->ruta;
    }

    /**
     * Called before saving the entity
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->imagen) {
            $imagen = sha1(uniqid(mt_rand(), true));
            $this->ruta = $imagen.'.'.$this->imagen->guessExtension();
        }
    }

    /**
     * Called before entity removal
     *
     * @ORM\PreRemove()
     */
    public function removeUpload()
    {
        if ($imagen = $this->getAbsolutePath()) {
            unlink($imagen);
        }
    }

    /**
     * Called after entity persistence
     *
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->imagen) {
            return;
        }
        $this->imagen->move(
            $this->getUploadRootDir(),
            $this->ruta
        );
        $this->imagen = null;
    }

    /**
     * @return string
     */
    public function getUploadDir()
    {
        return 'uploads/img';
    }

    /**
     * @return string
     */
    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    /**
     * @return string
     */
    public function getAbsolutePath()
    {
        return null === $this->ruta
            ? null : $this->getUploadRootDir() . DIRECTORY_SEPARATOR . $this->ruta;
    }

    /**
     * @return string
     */
    public function getWebPath()
    {
        return null === $this->ruta
            ? null : $this->getUploadDir() . DIRECTORY_SEPARATOR . $this->ruta;
    }

    /**
     * @param UploadedFile $imagen
     */
    public function setImagen(UploadedFile $imagen = null)
    {
        $this->imagen = $imagen;
    }

    /**
     * @return UploadedFile
     */
    public function getImagen()
    {
        return $this->imagen;
    }

}
