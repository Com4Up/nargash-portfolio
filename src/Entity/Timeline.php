<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TimelineRepository")
 */
class Timeline
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
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

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public function getMiniature(): ?Image
    {
        return $this->miniature;
    }

    public function setMiniature(Image $miniature): self
    {
        $this->miniature = $miniature;

        return $this;
    }

    public function toArray()
    {
        return [
            'titre' => $this->getTitre(),
            'description' => $this->getDescription(),
            'date' => $this->getDate(),
        ];
    }
    
}
