<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PayeRepository")
 */
class Paye
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
    private $refstock;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Payement", mappedBy="paye")
     */
    private $payement;

    /**
     * @ORM\Column(type="date")
     */
    private $datePayement;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TypePayement", mappedBy="paye")
     */
    private $typePayement;

    /**
     * @ORM\Column(type="boolean")
     */
    private $TVA;

    public function __construct()
    {
        $this->payement = new ArrayCollection();
        $this->typePayement = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRefstock(): ?string
    {
        return $this->refstock;
    }

    public function setRefstock(string $refstock): self
    {
        $this->refstock = $refstock;

        return $this;
    }

    /**
     * @return Collection|Payement[]
     */
    public function getPayement(): Collection
    {
        return $this->payement;
    }

    public function addPayement(Payement $payement): self
    {
        if (!$this->payement->contains($payement)) {
            $this->payement[] = $payement;
            $payement->setPaye($this);
        }

        return $this;
    }

    public function removePayement(Payement $payement): self
    {
        if ($this->payement->contains($payement)) {
            $this->payement->removeElement($payement);
            // set the owning side to null (unless already changed)
            if ($payement->getPaye() === $this) {
                $payement->setPaye(null);
            }
        }

        return $this;
    }

    public function getDatePayement(): ?\DateTimeInterface
    {
        return $this->datePayement;
    }

    public function setDatePayement(\DateTimeInterface $datePayement): self
    {
        $this->datePayement = $datePayement;

        return $this;
    }

    /**
     * @return Collection|TypePayement[]
     */
    public function getTypePayement(): Collection
    {
        return $this->typePayement;
    }

    public function addTypePayement(TypePayement $typePayement): self
    {
        if (!$this->typePayement->contains($typePayement)) {
            $this->typePayement[] = $typePayement;
            $typePayement->setPaye($this);
        }

        return $this;
    }

    public function removeTypePayement(TypePayement $typePayement): self
    {
        if ($this->typePayement->contains($typePayement)) {
            $this->typePayement->removeElement($typePayement);
            // set the owning side to null (unless already changed)
            if ($typePayement->getPaye() === $this) {
                $typePayement->setPaye(null);
            }
        }

        return $this;
    }

    public function getTVA(): ?bool
    {
        return $this->TVA;
    }

    public function setTVA(bool $TVA): self
    {
        $this->TVA = $TVA;

        return $this;
    }
}
