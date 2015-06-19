<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Miembro
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
     *      min = 3,
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
     *      min = 3,
     *      minMessage = "Los apellidos deben contener {{ limit }} caracteres como mínimo" )
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Los apellidos no puede contener dígitos" )
     */
    protected $apellidos;

    /**
     * @ORM\Column(type="date", nullable=true)
     *
     * @var \DateTime
     * @Assert\DateTime()
     */
    protected $fechaNacimiento;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    protected $correoElectronico;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     * @Assert\Length(
     *      min = 5,
     *      minMessage = "El teléfono debe contener {{ limit }} caracteres como mínimo" )
     */
    protected $telefono;

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
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "El tipo de miembro debe contener {{ limit }} caracteres como mínimo" )
     */
    protected $tipo;

    /**
     * @ORM\ManyToOne(targetEntity="Familia", inversedBy="miembros")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var Familia
     *
     */
    protected $familia;

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
     * @return Miembro
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
     * @return Miembro
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
     * @return Miembro
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
     * @return Miembro
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
     * Set telefono
     *
     * @param string $telefono
     * @return Miembro
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
     * Set sexo
     *
     * @param string $sexo
     * @return Miembro
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
     * Set tipo
     *
     * @param string $tipo
     * @return Miembro
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set familia
     *
     * @param \AppBundle\Entity\Miembro $miembro
     */
    public function setFamilia(\AppBundle\Entity\Familia $familia = null)
    {
        $this->familia = $familia;
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

}
