<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TricksRepository")
 */
class Tricks
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
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TricksGroup", inversedBy="tricks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $TrickGroup;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TricksImages", mappedBy="trick", orphanRemoval=true)
     */
    private $tricksImages;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->tricksImages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getTrickGroup(): ?TricksGroup
    {
        return $this->TrickGroup;
    }

    public function setTrickGroup(?TricksGroup $TrickGroup): self
    {
        $this->TrickGroup = $TrickGroup;

        return $this;
    }

    /**
     * @return Collection|TricksImages[]
     */
    public function getTricksImages(): Collection
    {
        return $this->tricksImages;
    }

    public function addTricksImage(TricksImages $tricksImage): self
    {
        if (!$this->tricksImages->contains($tricksImage)) {
            $this->tricksImages[] = $tricksImage;
            $tricksImage->setTrick($this);
        }

        return $this;
    }

    public function removeTricksImage(TricksImages $tricksImage): self
    {
        if ($this->tricksImages->contains($tricksImage)) {
            $this->tricksImages->removeElement($tricksImage);
            // set the owning side to null (unless already changed)
            if ($tricksImage->getTrick() === $this) {
                $tricksImage->setTrick(null);
            }
        }

        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }

}