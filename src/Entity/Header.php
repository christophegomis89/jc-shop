<?php

namespace App\Entity;

use App\Repository\HeaderRepository;
use Doctrine\ORM\Mapping as ORM;

   /**
    * @ORM\Entity(repositoryClass=HeaderRepository::class)
    */
   class Header
   {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $btnTitle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $btnUrl;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ullistration;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getBtnTitle(): ?string
    {
        return $this->btnTitle;
    }

    public function setBtnTitle(string $btnTitle): self
    {
        $this->btnTitle = $btnTitle;

        return $this;
    }

    public function getBtnUrl(): ?string
    {
        return $this->btnUrl;
    }

    public function setBtnUrl(string $btnUrl): self
    {
        $this->btnUrl = $btnUrl;

        return $this;
    }

    public function getUllistration(): ?string
    {
        return $this->ullistration;
    }

    public function setUllistration(string $ullistration): self
    {
        $this->ullistration = $ullistration;

        return $this;
    }
}
