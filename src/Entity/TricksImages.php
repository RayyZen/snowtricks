<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TricksImagesRepository")
 */
class TricksImages
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\tricks", inversedBy="tricksImages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trick;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isThumbnail;

    public function __construct()
    {
        $this->isThumbnail = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrick(): ?tricks
    {
        return $this->trick;
    }

    public function setTrick(?tricks $trick): self
    {
        $this->trick = $trick;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getIsThumbnail(): ?bool
    {
        return $this->isThumbnail;
    }

    public function setIsThumbnail(bool $isThumbnail): self
    {
        $this->isThumbnail = $isThumbnail;

        return $this;
    }
}
