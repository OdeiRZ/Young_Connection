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
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "El nombre debe contener {{ limit }} caracteres como mínimo" )
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="El nombre no puede contener dígitos" )
     */
    protected $nombre;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "Los apellidos deben contener {{ limit }} caracteres como mínimo" )
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Los apellidos no deben contener dígitos" )
     */
    protected $apellidos;

    /**
     * @ORM\Column(type="date")
     *
     * @var \DateTime
     * @Assert\DateTime()
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
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     * @Assert\Length(
     *      min = 5,
     *      minMessage = "El teléfono debe contener {{ limit }} caracteres como mínimo",
     *      max = 30,
     *      maxMessage = "El teléfono debe contener menos de {{ limit }} caracteres" )
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
     * @ORM\Column(type="boolean")
     *
     * @var boolean
     */
    protected $esAlumno;

    /**
     * @ORM\OneToMany(targetEntity="Mensaje", mappedBy="usuarioOrigen" )
     * @ORM\JoinColumn(nullable=false)
     *
     * @var Mensaje
     */
    protected $mensajes;

    /**
     * @ORM\Column(type="string", nullable=false)
     *
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "El país debe contener {{ limit }} caracteres como mínimo" )
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message = "El país no puede contener dígitos" )
     */
    protected $pais;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     * @var boolean
     */
    protected $tieneProblemasSalud;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    protected $detallesProblemasSalud;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     * @var boolean
     */
    protected $esFumador;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     * @var boolean
     */
    protected $esBebedor;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     * @var boolean
     */
    protected $haViajadoExtranjero;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    protected $detallesViajeExtranjero;

    /**
     * @ORM\ManyToMany(targetEntity="Usuario")
     * @ORM\JoinColumn(nullable=true)
     *
     * @var Usuario
     */
    protected $preferenciaCompanero;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    protected $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="Curso", inversedBy="alumnos")
     * @ORM\JoinColumn(nullable=true)
     *
     * @var Curso
     */
    protected $curso;

    /**
     * @ORM\OneToMany(targetEntity="Idioma", mappedBy="alumno", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\JoinColumn(nullable=true)
     *
     * @var Idioma
     */
    protected $idiomas;

    /**
     * @ORM\ManyToMany(targetEntity="Aficion", inversedBy="alumnos")
     * @ORM\JoinColumn(nullable=true)
     * @ORM\OrderBy({"descripcion" = "ASC"})
     *
     * @var Aficion
     */
    protected $aficiones;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean
     */
    protected $estaDisponible;

    /**
     * @ORM\ManyToOne(targetEntity="Familia", inversedBy="alumnos")
     * @ORM\JoinColumn(nullable=true)
     *
     * @var Familia
     *
     */
    protected $familia;

    /**
     * @ORM\OneToMany(targetEntity="Alojamiento", mappedBy="alumno")
     * @ORM\JoinColumn(nullable=true)
     *
     * @var Alojamiento
     *
     */
    protected $alojamientos;

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
        if ($this->getEsAlumno()) {
            $roles[] = 'ROLE_ALUMNO';
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
            //$this->setRuta("user.png");//
            //unlink($imagen);
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
        //$this->imagen = null;
        $this->imagen = $imagen;
    }

    /**
     * @return UploadedFile
     */
    public function getImagen()
    {
        return $this->imagen;
    }


    /**
     * Set esAlumno
     *
     * @param boolean $esAlumno
     * @return Usuario
     */
    public function setEsAlumno($esAlumno)
    {
        $this->esAlumno = $esAlumno;

        return $this;
    }

    /**
     * Get esAlumno
     *
     * @return boolean 
     */
    public function getEsAlumno()
    {
        return $this->esAlumno;
    }

    /**
     * Set tieneProblemasSalud
     *
     * @param boolean $tieneProblemasSalud
     * @return Usuario
     */
    public function setTieneProblemasSalud($tieneProblemasSalud)
    {
        $this->tieneProblemasSalud = $tieneProblemasSalud;

        return $this;
    }

    /**
     * Get tieneProblemasSalud
     *
     * @return boolean 
     */
    public function getTieneProblemasSalud()
    {
        return $this->tieneProblemasSalud;
    }

    /**
     * Set detallesProblemasSalud
     *
     * @param string $detallesProblemasSalud
     * @return Usuario
     */
    public function setDetallesProblemasSalud($detallesProblemasSalud)
    {
        $this->detallesProblemasSalud = $detallesProblemasSalud;

        return $this;
    }

    /**
     * Get detallesProblemasSalud
     *
     * @return string 
     */
    public function getDetallesProblemasSalud()
    {
        return $this->detallesProblemasSalud;
    }

    /**
     * Set esFumador
     *
     * @param boolean $esFumador
     * @return Usuario
     */
    public function setEsFumador($esFumador)
    {
        $this->esFumador = $esFumador;

        return $this;
    }

    /**
     * Get esFumador
     *
     * @return boolean 
     */
    public function getEsFumador()
    {
        return $this->esFumador;
    }

    /**
     * Set esBebedor
     *
     * @param boolean $esBebedor
     * @return Usuario
     */
    public function setEsBebedor($esBebedor)
    {
        $this->esBebedor = $esBebedor;

        return $this;
    }

    /**
     * Get esBebedor
     *
     * @return boolean 
     */
    public function getEsBebedor()
    {
        return $this->esBebedor;
    }

    /**
     * Set haViajadoExtranjero
     *
     * @param boolean $haViajadoExtranjero
     * @return Usuario
     */
    public function setHaViajadoExtranjero($haViajadoExtranjero)
    {
        $this->haViajadoExtranjero = $haViajadoExtranjero;

        return $this;
    }

    /**
     * Get haViajadoExtranjero
     *
     * @return boolean 
     */
    public function getHaViajadoExtranjero()
    {
        return $this->haViajadoExtranjero;
    }

    /**
     * Set detallesViajeExtranjero
     *
     * @param string $detallesViajeExtranjero
     * @return Usuario
     */
    public function setDetallesViajeExtranjero($detallesViajeExtranjero)
    {
        $this->detallesViajeExtranjero = $detallesViajeExtranjero;

        return $this;
    }

    /**
     * Get detallesViajeExtranjero
     *
     * @return string 
     */
    public function getDetallesViajeExtranjero()
    {
        return $this->detallesViajeExtranjero;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Usuario
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Add preferenciaCompanero
     *
     * @param \AppBundle\Entity\Usuario $preferenciaCompanero
     * @return Usuario
     */
    public function addPreferenciaCompanero(\AppBundle\Entity\Usuario $preferenciaCompanero)
    {
        $this->preferenciaCompanero[] = $preferenciaCompanero;

        return $this;
    }

    /**
     * Remove preferenciaCompanero
     *
     * @param \AppBundle\Entity\Usuario $preferenciaCompanero
     */
    public function removePreferenciaCompanero(\AppBundle\Entity\Usuario $preferenciaCompanero)
    {
        $this->preferenciaCompanero->removeElement($preferenciaCompanero);
    }

    /**
     * Get preferenciaCompanero
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPreferenciaCompanero()
    {
        return $this->preferenciaCompanero;
    }

    /**
     * Set curso
     *
     * @param \AppBundle\Entity\Curso $curso
     * @return Usuario
     */
    public function setCurso(\AppBundle\Entity\Curso $curso = null)
    {
        $this->curso = $curso;

        return $this;
    }

    /**
     * Get curso
     *
     * @return \AppBundle\Entity\Curso 
     */
    public function getCurso()
    {
        return $this->curso;
    }

    /**
     * Add idiomas
     *
     * @param \AppBundle\Entity\Idioma $idiomas
     */
    public function addIdioma(\AppBundle\Entity\Idioma $idiomas)
    {
        $this->idiomas[] = $idiomas;
        $idiomas->setAlumno($this);

    }

    /**
     * Remove idiomas
     *
     * @param \AppBundle\Entity\Idioma $idiomas
     */
    public function removeIdioma(\AppBundle\Entity\Idioma $idiomas)
    {
        $this->idiomas->removeElement($idiomas);
    }

    /**
     * Get idiomas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdiomas()
    {
        return $this->idiomas;
    }

    /**
     * Add aficiones
     *
     * @param \AppBundle\Entity\Aficion $aficiones
     * @return Usuario
     */
    public function addAficione(\AppBundle\Entity\Aficion $aficiones)
    {
        $this->aficiones[] = $aficiones;

        return $this;
    }

    /**
     * Remove aficiones
     *
     * @param \AppBundle\Entity\Aficion $aficiones
     */
    public function removeAficione(\AppBundle\Entity\Aficion $aficiones)
    {
        $this->aficiones->removeElement($aficiones);
    }

    /**
     * Get aficiones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAficiones()
    {
        return $this->aficiones;
    }

    /**
     * Set familia
     *
     * @param \AppBundle\Entity\Familia $familia
     * @return Usuario
     */
    public function setFamilia(\AppBundle\Entity\Familia $familia = null)
    {
        $this->familia = $familia;

        return $this;
    }

    /**
     * Get familia
     *
     * @return \AppBundle\Entity\Familia 
     */
    public function getFamilia()
    {
        return $this->familia;
    }

    /**
     *
     */
    public function __toString()
    {
        $aux = ($this->getEsAlumno() or $this->getEsCoordinador()) ? '(' . $this->getCurso() . ') - ' : '';
        return $aux . $this->getApellidos() . ' ' .
               $this->getNombre();
    }

    /**
     * Add alojamientos
     *
     * @param \AppBundle\Entity\Alojamiento $alojamientos
     * @return Usuario
     */
    public function addAlojamiento(\AppBundle\Entity\Alojamiento $alojamientos)
    {
        $this->alojamientos[] = $alojamientos;

        return $this;
    }

    /**
     * Remove alojamientos
     *
     * @param \AppBundle\Entity\Alojamiento $alojamientos
     */
    public function removeAlojamiento(\AppBundle\Entity\Alojamiento $alojamientos)
    {
        $this->alojamientos->removeElement($alojamientos);
    }

    /**
     * Get alojamientos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAlojamientos()
    {
        return $this->alojamientos;
    }

    /**
     * Set pais
     *
     * @param boolean $pais
     * @return Usuario
     */
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return boolean 
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set estaDisponible
     *
     * @param boolean $estaDisponible
     * @return Usuario
     */
    public function setEstaDisponible($estaDisponible)
    {
        $this->estaDisponible = $estaDisponible;

        return $this;
    }

    /**
     * Get estaDisponible
     *
     * @return boolean 
     */
    public function getEstaDisponible()
    {
        return $this->estaDisponible;
    }
}
