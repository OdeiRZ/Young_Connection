<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Alumno
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
     * @ORM\Column(type="boolean")
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
     * @ORM\Column(type="boolean")
     *
     * @var boolean
     */
    protected $esFumador;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean
     */
    protected $esBebedor;

    /**
     * @ORM\Column(type="boolean")
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
     * @ORM\ManyToMany(targetEntity="Alumno")
     * @ORM\JoinColumn(nullable=true)
     *
     * @var Alumno
     */
    protected $preferenciaCompanero;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    protected $descripcion;

    /**
     * @ORM\OneToOne(targetEntity="Usuario")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var Usuario
     */
    protected $usuario;

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
     * Set tieneProblemasSalud
     *
     * @param boolean $tieneProblemasSalud
     * @return Alumno
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
     * @return Alumno
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
     * @return Alumno
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
     * @return Alumno
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
     * @return Alumno
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
     * @return Alumno
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
     * Set preferenciaCompanero
     *
     * @param \Alumno $preferenciaCompanero
     * @return Alumno
     */
    public function setPreferenciaCompanero(\Alumno $preferenciaCompanero)
    {
        $this->preferenciaCompanero = $preferenciaCompanero;

        return $this;
    }

    /**
     * Get preferenciaCompanero
     *
     * @return \Alumno 
     */
    public function getPreferenciaCompanero()
    {
        return $this->preferenciaCompanero;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Alumno
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
     * Set usuario
     *
     * @param \AppBundle\Entity\Usuario $usuario
     * @return Alumno
     */
    public function setUsuario(\AppBundle\Entity\Usuario $usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \AppBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     *
     */
    public function __toString()
    {
        return $this->getUsuario()->getApellidos()
        . ' ' . $this->getUsuario()->getNombre();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->preferenciaCompanero = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add preferenciaCompanero
     *
     * @param \AppBundle\Entity\Alumno $preferenciaCompanero
     * @return Alumno
     */
    public function addPreferenciaCompanero(\AppBundle\Entity\Alumno $preferenciaCompanero)
    {
        $this->preferenciaCompanero[] = $preferenciaCompanero;

        return $this;
    }

    /**
     * Remove preferenciaCompanero
     *
     * @param \AppBundle\Entity\Alumno $preferenciaCompanero
     */
    public function removePreferenciaCompanero(\AppBundle\Entity\Alumno $preferenciaCompanero)
    {
        $this->preferenciaCompanero->removeElement($preferenciaCompanero);
    }
}