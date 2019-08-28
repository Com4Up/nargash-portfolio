<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjetRepository")
 */
class Projet
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $client;

    /**
    * @ORM\Column(type="string", length=255)
     */
    private $categorie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $URL_site;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Image", orphanRemoval=true, cascade={"persist" ,"remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $miniature;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="projects", orphanRemoval=true,cascade={"persist" ,"remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $gallery;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Skill" , inversedBy="projects")
     */
    private $skills;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

    public function __construct()
    {
        $this->gallery = new ArrayCollection();
        $this->skills = new ArrayCollection();

        $date = \DateTime::createFromFormat('d-m-Y','now');
        $timeZone = new \DateTimeZone('Europe/Paris');
        $date2 = new \DateTime($date);
        $date2->setTimeZone($timeZone);
        $this->date = $date2;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getSlug(): ?string
    {
        return (new Slugify())->slugify($this->title);
    }


    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(string $client): self
    {
        $this->client = $client;

        return $this;
    }

 
    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
    
    public function getURLSite(): ?string
    {
        return $this->URL_site;
    }

    public function setURLSite(?string $URL_site): self
    {
        $this->URL_site = $URL_site;

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

    /**
     * @return Collection|Image[]
     */
    public function getGallery(): Collection
    {
        return $this->gallery;
    }

    public function addGallery(Image $gallery): self
    {
        $gallery->setProjects($this);
        $this->gallery->add($gallery);
        return $this;
    }

    public function removeGallery(Image $gallery): self
    {
        if ($this->gallery->contains($gallery)) {
            $this->gallery->removeElement($gallery);
            // set the owning side to null (unless already changed)
            if ($gallery->getProjects() === $this) {
                $gallery->setProjects(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Technologies[]
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
            $skill->addProject($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): self
    {
        if ($this->skills->contains($skill)) {
            $this->skills->removeElement($skill);
            $skill->removeProject($this);
        }

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

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;
        return $this;
    }
}
