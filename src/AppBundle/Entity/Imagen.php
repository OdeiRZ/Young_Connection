<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Imagen
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text", length=255, nullable=false)
     *
     * @var string
     */
    protected $path;

    /**
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     *
     * @var File
     * @Assert\File(    maxSize = "2M",
     *                  mimeTypes = {"image/jpeg", "image/gif", "image/png", "image/tiff"},
     *                  maxSizeMessage = "The maximum allowed file size is 2MB.",
     *                  mimeTypesMessage = "Only the filetypes image are allowed.")
     */
    protected $file;

    /**
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $path
     * @return Imagen
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Called before saving the entity
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename.'.'.$this->file->guessExtension();
        }
    }

    /**
     * Called before entity removal
     *
     * @ORM\PreRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
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
        if (null === $this->file) {
            return;
        }
        $this->file->move(
            $this->getUploadRootDir(),
            $this->path
        );
        // Set the path property to the filename where you've saved the file
        //$this->path = $this->file->getClientOriginalName();
        // Clean up the file property as you won't need it anymore
        $this->file = null;
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     *
     */
    public function getUploadDir()
    {
        return 'uploads/img';
    }

    /**
     *
     */
    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    /**
     *
     */
    public function getAbsolutePath()
    {
        return null === $this->path
            ? null : $this->getUploadRootDir() . DIRECTORY_SEPARATOR . $this->path;
    }

    /**
     *
     */
    public function getWebPath()
    {
        return null === $this->path
            ? null : $this->getUploadDir() . DIRECTORY_SEPARATOR . $this->path;
    }
}
