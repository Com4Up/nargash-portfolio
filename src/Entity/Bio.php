<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BioRepository")
 */
class Bio
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Image", orphanRemoval=true, cascade={"persist" ,"remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $miniature;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMiniature(): ?Image
    {
        return $this->miniature;
    }

    public function setMiniature(Image $miniature): self
    {
        $this->miniature = $miniature;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
