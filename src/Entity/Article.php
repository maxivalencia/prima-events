<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
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
    private $designation;

    /**
     * @ORM\Column(type="float")
     */
    private $prix_unitaire;

    /**
     * @ORM\Column(type="float")
     */
    private $prix_casse;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Stock", inversedBy="article")
     */
    private $stock;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Stock", mappedBy="article")
     */
    private $stocks;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SortieArticle", mappedBy="article")
     */
    private $sortieArticles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Retour", mappedBy="article")
     */
    private $retours;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RetourArticle", mappedBy="article")
     */
    private $retourArticles;

    public function __construct()
    {
        $this->stocks = new ArrayCollection();
        $this->sortieArticles = new ArrayCollection();
        $this->retours = new ArrayCollection();
        $this->retourArticles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getPrixUnitaire(): ?float
    {
        return $this->prix_unitaire;
    }

    public function setPrixUnitaire(float $prix_unitaire): self
    {
        $this->prix_unitaire = $prix_unitaire;

        return $this;
    }

    public function getPrixCasse(): ?float
    {
        return $this->prix_casse;
    }

    public function setPrixCasse(float $prix_casse): self
    {
        $this->prix_casse = $prix_casse;

        return $this;
    }

    public function getStock(): ?Stock
    {
        return $this->stock;
    }

    public function setStock(?Stock $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * toString
     * @return string
     */
    public function __toString()
    {
        return $this->getDesignation();
    }

    /**
     * @return Collection|Stock[]
     */
    public function getStocks(): Collection
    {
        return $this->stocks;
    }

    public function addStock(Stock $stock): self
    {
        if (!$this->stocks->contains($stock)) {
            $this->stocks[] = $stock;
            $stock->setArticle($this);
        }

        return $this;
    }

    public function removeStock(Stock $stock): self
    {
        if ($this->stocks->contains($stock)) {
            $this->stocks->removeElement($stock);
            // set the owning side to null (unless already changed)
            if ($stock->getArticle() === $this) {
                $stock->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SortieArticle[]
     */
    public function getSortieArticles(): Collection
    {
        return $this->sortieArticles;
    }

    public function addSortieArticle(SortieArticle $sortieArticle): self
    {
        if (!$this->sortieArticles->contains($sortieArticle)) {
            $this->sortieArticles[] = $sortieArticle;
            $sortieArticle->setArticle($this);
        }

        return $this;
    }

    public function removeSortieArticle(SortieArticle $sortieArticle): self
    {
        if ($this->sortieArticles->contains($sortieArticle)) {
            $this->sortieArticles->removeElement($sortieArticle);
            // set the owning side to null (unless already changed)
            if ($sortieArticle->getArticle() === $this) {
                $sortieArticle->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Retour[]
     */
    public function getRetours(): Collection
    {
        return $this->retours;
    }

    public function addRetour(Retour $retour): self
    {
        if (!$this->retours->contains($retour)) {
            $this->retours[] = $retour;
            $retour->setArticle($this);
        }

        return $this;
    }

    public function removeRetour(Retour $retour): self
    {
        if ($this->retours->contains($retour)) {
            $this->retours->removeElement($retour);
            // set the owning side to null (unless already changed)
            if ($retour->getArticle() === $this) {
                $retour->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RetourArticle[]
     */
    public function getRetourArticles(): Collection
    {
        return $this->retourArticles;
    }

    public function addRetourArticle(RetourArticle $retourArticle): self
    {
        if (!$this->retourArticles->contains($retourArticle)) {
            $this->retourArticles[] = $retourArticle;
            $retourArticle->setArticle($this);
        }

        return $this;
    }

    public function removeRetourArticle(RetourArticle $retourArticle): self
    {
        if ($this->retourArticles->contains($retourArticle)) {
            $this->retourArticles->removeElement($retourArticle);
            // set the owning side to null (unless already changed)
            if ($retourArticle->getArticle() === $this) {
                $retourArticle->setArticle(null);
            }
        }

        return $this;
    }
}
