<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Mensaje
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
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     * @Assert\DateTime()
     */
    protected $fechaEnvio;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean
     */
    protected $estaRecibido;

    /**
     * @ORM\Column(type="text")
     *
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "El contenido debe contener {{ limit }} caracteres como mínimo" )
     */
    protected $contenido;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="mensajes")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var Usuario
     */
    protected $usuarioOrigen;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var Usuario
     */
    protected $usuarioDestino;

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
     * Set fechaEnvio
     *
     * @param \DateTime $fechaEnvio
     * @return Mensaje
     */
    public function setFechaEnvio($fechaEnvio)
    {
        $this->fechaEnvio = $fechaEnvio;

        return $this;
    }

    /**
     * Get fechaEnvio
     *
     * @return \DateTime 
     */
    public function getFechaEnvio()
    {
        return $this->fechaEnvio;
    }

    /**
     * Set fechaRecepcion
     *
     * @param \DateTime $fechaRecepcion
     * @return Mensaje
     */
    public function setFechaRecepcion($fechaRecepcion)
    {
        $this->fechaRecepcion = $fechaRecepcion;

        return $this;
    }

    /**
     * Get fechaRecepcion
     *
     * @return \DateTime 
     */
    public function getFechaRecepcion()
    {
        return $this->fechaRecepcion;
    }

    /**
     * Set contenido
     *
     * @param string $contenido
     * @return Mensaje
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;

        return $this;
    }

    /**
     * Get contenido
     *
     * @return string 
     */
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * Set usuarioOrigen
     *
     * @param \AppBundle\Entity\Usuario $usuarioOrigen
     * @return Mensaje
     */
    public function setUsuarioOrigen(\AppBundle\Entity\Usuario $usuarioOrigen)
    {
        $this->usuarioOrigen = $usuarioOrigen;

        return $this;
    }

    /**
     * Get usuarioOrigen
     *
     * @return \AppBundle\Entity\Usuario 
     */
    public function getUsuarioOrigen()
    {
        return $this->usuarioOrigen;
    }

    /**
     * Set usuarioDestino
     *
     * @param \AppBundle\Entity\Usuario $usuarioDestino
     * @return Mensaje
     */
    public function setUsuarioDestino(\AppBundle\Entity\Usuario $usuarioDestino)
    {
        $this->usuarioDestino = $usuarioDestino;

        return $this;
    }

    /**
     * Get usuarioDestino
     *
     * @return \AppBundle\Entity\Usuario 
     */
    public function getUsuarioDestino()
    {
        return $this->usuarioDestino;
    }

    /**
     * Set estaRecibido
     *
     * @param boolean $estaRecibido
     * @return Mensaje
     */
    public function setEstaRecibido($estaRecibido)
    {
        $this->estaRecibido = $estaRecibido;

        return $this;
    }

    /**
     * Get estaRecibido
     *
     * @return boolean 
     */
    public function getEstaRecibido()
    {
        return $this->estaRecibido;
    }
}
