<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 */
class Utilisateur
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
    private $login;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Stock", inversedBy="user")
     */
    private $stock;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Stock", mappedBy="user")
     */
    private $stocks;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Stock", mappedBy="userSortie")
     */
    private $stocksortie;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Stock", mappedBy="userRetour")
     */
    private $stockretour;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Role", inversedBy="utilisateurid")
     */
    private $role;

    public function __construct()
    {
        $this->stocks = new ArrayCollection();
        $this->stocksortie = new ArrayCollection();
        $this->stockretour = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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
        return $this->getLogin();
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
            $stock->setUser($this);
        }

        return $this;
    }

    public function removeStock(Stock $stock): self
    {
        if ($this->stocks->contains($stock)) {
            $this->stocks->removeElement($stock);
            // set the owning side to null (unless already changed)
            if ($stock->getUser() === $this) {
                $stock->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Stock[]
     */
    public function getStocksortie(): Collection
    {
        return $this->stocksortie;
    }

    public function addStocksortie(Stock $stocksortie): self
    {
        if (!$this->stocksortie->contains($stocksortie)) {
            $this->stocksortie[] = $stocksortie;
            $stocksortie->setUserSortie($this);
        }

        return $this;
    }

    public function removeStocksortie(Stock $stocksortie): self
    {
        if ($this->stocksortie->contains($stocksortie)) {
            $this->stocksortie->removeElement($stocksortie);
            // set the owning side to null (unless already changed)
            if ($stocksortie->getUserSortie() === $this) {
                $stocksortie->setUserSortie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Stock[]
     */
    public function getStockretour(): Collection
    {
        return $this->stockretour;
    }

    public function addStockretour(Stock $stockretour): self
    {
        if (!$this->stockretour->contains($stockretour)) {
            $this->stockretour[] = $stockretour;
            $stockretour->setUserRetour($this);
        }

        return $this;
    }

    public function removeStockretour(Stock $stockretour): self
    {
        if ($this->stockretour->contains($stockretour)) {
            $this->stockretour->removeElement($stockretour);
            // set the owning side to null (unless already changed)
            if ($stockretour->getUserRetour() === $this) {
                $stockretour->setUserRetour(null);
            }
        }

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }
}
