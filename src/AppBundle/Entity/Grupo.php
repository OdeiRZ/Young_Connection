<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @UniqueEntity(fields="descripcion", message="La descripción ya está registrada")
 */
class Grupo
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
     *      minMessage = "La descripción debe contener {{ limit }} caracteres como mínimo" )
     */
    protected $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var Usuario
     *
     */
    protected $coordinador;

    /**
     * @ORM\OneToMany(targetEntity="Alojamiento", mappedBy="grupo", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\JoinColumn(nullable=true)
     *
     * @var Alojamiento
     *
     */
    protected $alojamientos;

    /**
     * @ORM\ManyToOne(targetEntity="Intercambio", inversedBy="grupos")
     * @ORM\JoinColumn(nullable=true)
     *
     * @var Intercambio
     *
     */
    protected $intercambio;

    /**
     *
     */
    public function __toString()
    {
        return $this->getDescripcion();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->alojamientos = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Add alojamientos
     *
     * @param \AppBundle\Entity\Alojamiento $alojamientos
     * @return Grupo
     */
    public function addAlojamiento(\AppBundle\Entity\Alojamiento $alojamientos)
    {
        $this->alojamientos[] = $alojamientos;
        $alojamientos->setGrupo($this);
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
     * Set coordinador
     *
     * @param \AppBundle\Entity\Usuario $coordinador
     * @return Grupo
     */
    public function setCoordinador(\AppBundle\Entity\Usuario $coordinador)
    {
        $this->coordinador = $coordinador;

        return $this;
    }

    /**
     * Get coordinador
     *
     * @return \AppBundle\Entity\Usuario 
     */
    public function getCoordinador()
    {
        return $this->coordinador;
    }

    /**
     * Set intercambio
     *
     * @param \AppBundle\Entity\Intercambio $intercambio
     * @return Grupo
     */
    public function setIntercambio(\AppBundle\Entity\Intercambio $intercambio = null)
    {
        $this->intercambio = $intercambio;

        return $this;
    }

    /**
     * Get intercambio
     *
     * @return \AppBundle\Entity\Intercambio 
     */
    public function getIntercambio()
    {
        return $this->intercambio;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Grupo
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
}
