<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, upload the product brochure as a PDF file.")
     * @Assert\File(mimeTypes={ "image/*" })
     */
    private $filename;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $alt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Projet", inversedBy="gallery", cascade={"persist" ,"remove"})
     * @ORM\JoinColumn(nullable=true , onDelete="SET NULL")
     */
    private $projects;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): self
    {
        $this->alt = $alt;

        return $this;
    }

    public function getProjects(): ?Projet
    {
        return $this->projects;
    }

    public function setProjects(?Projet $projects): self
    {
        $this->projects = $projects;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getPath();
    }

    // public function getProject(): ?Projects
    // {
    //     return $this->project;
    // }

    // public function setProject(?Projects $project): self
    // {
    //     $this->project = $project;

    //     return $this;
    // }
}
