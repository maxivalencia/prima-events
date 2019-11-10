<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SortieArticleRepository")
 */
class SortieArticle
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
    private $refernce;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="sortieArticles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantiteCommander;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantiteSortie;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $reste;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRefernce(): ?string
    {
        return $this->refernce;
    }

    public function setRefernce(string $refernce): self
    {
        $this->refernce = $refernce;

        return $this;
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

    public function getQuantiteCommander(): ?int
    {
        return $this->quantiteCommander;
    }

    public function setQuantiteCommander(int $quantiteCommander): self
    {
        $this->quantiteCommander = $quantiteCommander;

        return $this;
    }

    public function getQuantiteSortie(): ?int
    {
        return $this->quantiteSortie;
    }

    public function setQuantiteSortie(int $quantiteSortie): self
    {
        $this->quantiteSortie = $quantiteSortie;

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

    public function getReste(): ?int
    {
        return $this->reste;
    }

    public function setReste(?int $reste): self
    {
        $this->reste = $reste;

        return $this;
    }
}
