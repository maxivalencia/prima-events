<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TypeClient", mappedBy="client")
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Privilege", mappedBy="client")
     */
    private $privilege;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Stock", inversedBy="client")
     */
    private $stock;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Stock", mappedBy="client")
     */
    private $stocks;

    public function __construct()
    {
        $this->type = new ArrayCollection();
        $this->privilege = new ArrayCollection();
        $this->stocks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection|TypeClient[]
     */
    public function getType(): Collection
    {
        return $this->type;
    }

    public function addType(TypeClient $type): self
    {
        if (!$this->type->contains($type)) {
            $this->type[] = $type;
            $type->setClient($this);
        }

        return $this;
    }

    public function removeType(TypeClient $type): self
    {
        if ($this->type->contains($type)) {
            $this->type->removeElement($type);
            // set the owning side to null (unless already changed)
            if ($type->getClient() === $this) {
                $type->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Privilege[]
     */
    public function getPrivilege(): Collection
    {
        return $this->privilege;
    }

    public function addPrivilege(Privilege $privilege): self
    {
        if (!$this->privilege->contains($privilege)) {
            $this->privilege[] = $privilege;
            $privilege->setClient($this);
        }

        return $this;
    }

    public function removePrivilege(Privilege $privilege): self
    {
        if ($this->privilege->contains($privilege)) {
            $this->privilege->removeElement($privilege);
            // set the owning side to null (unless already changed)
            if ($privilege->getClient() === $this) {
                $privilege->setClient(null);
            }
        }

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
        return $this->getNom();
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
            $stock->setClient($this);
        }

        return $this;
    }

    public function removeStock(Stock $stock): self
    {
        if ($this->stocks->contains($stock)) {
            $this->stocks->removeElement($stock);
            // set the owning side to null (unless already changed)
            if ($stock->getClient() === $this) {
                $stock->setClient(null);
            }
        }

        return $this;
    }
}
