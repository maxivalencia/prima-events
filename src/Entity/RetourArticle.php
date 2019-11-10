<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RetourArticleRepository")
 */
class RetourArticle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="retourArticles")
     */
    private $article;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantitesortie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @ORM\Column(type="date")
     */
    private $dateRetour;

    /**
     * @ORM\Column(type="integer")
     */
    private $quatiteRetourner;

    /**
     * @ORM\Column(type="integer")
     */
    private $cassure;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="integer")
     */
    private $reste;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getQuantitesortie(): ?int
    {
        return $this->quantitesortie;
    }

    public function setQuantitesortie(int $quantitesortie): self
    {
        $this->quantitesortie = $quantitesortie;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getDateRetour(): ?\DateTimeInterface
    {
        return $this->dateRetour;
    }

    public function setDateRetour(\DateTimeInterface $dateRetour): self
    {
        $this->dateRetour = $dateRetour;

        return $this;
    }

    public function getQuatiteRetourner(): ?int
    {
        return $this->quatiteRetourner;
    }

    public function setQuatiteRetourner(int $quatiteRetourner): self
    {
        $this->quatiteRetourner = $quatiteRetourner;

        return $this;
    }

    public function getCassure(): ?int
    {
        return $this->cassure;
    }

    public function setCassure(int $cassure): self
    {
        $this->cassure = $cassure;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getReste(): ?int
    {
        return $this->reste;
    }

    public function setReste(int $reste): self
    {
        $this->reste = $reste;

        return $this;
    }
}
