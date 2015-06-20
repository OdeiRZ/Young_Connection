<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Centro
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
     */
    protected $nombre;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "La ciudad debe contener {{ limit }} caracteres como mínimo" )
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="La ciudad no puede contener dígitos" )
     */
    protected $ciudad;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "La provincia debe contener {{ limit }} caracteres como mínimo" )
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="La provincia no puede contener dígitos" )
     */
    protected $provincia;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "El pais debe contener {{ limit }} caracteres como mínimo" )
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="El país no puede contener dígitos" )
     */
    protected $pais;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     * @Assert\Length(
     *      min = 5,
     *      minMessage = "La dirección debe contener {{ limit }} caracteres como mínimo" )
     */
    protected $direccion;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     * @Assert\Length(
     *      min = 5,
     *      minMessage = "El teléfono debe contener {{ limit }} caracteres como mínimo" )
     */
    protected $telefono;

    /**
     * @ORM\OneToMany(targetEntity="Curso", mappedBy="centro")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var Curso
     */
    protected $cursos;

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
     * @return Centro
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
     * Set direccion
     *
     * @param string $direccion
     * @return Centro
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
     * Set telefono
     *
     * @param string $telefono
     * @return Centro
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
     * Set ciudad
     *
     * @param string $ciudad
     * @return Centro
     */
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return string 
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     *
     */
    public function __toString()
    {
        return $this->getNombre() . " - " .
               $this->getCiudad();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cursos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add cursos
     *
     * @param \AppBundle\Entity\Curso $cursos
     * @return Centro
     */
    public function addCurso(\AppBundle\Entity\Curso $cursos)
    {
        $this->cursos[] = $cursos;

        return $this;
    }

    /**
     * Remove cursos
     *
     * @param \AppBundle\Entity\Curso $cursos
     */
    public function removeCurso(\AppBundle\Entity\Curso $cursos)
    {
        $this->cursos->removeElement($cursos);
    }

    /**
     * Get cursos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCursos()
    {
        return $this->cursos;
    }

    /**
     * Set provincia
     *
     * @param string $provincia
     * @return Centro
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return string 
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set pais
     *
     * @param string $pais
     * @return Centro
     */
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return string 
     */
    public function getPais()
    {
        return $this->pais;
    }
}
