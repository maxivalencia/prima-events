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
     * @ORM\Column(type="date")
     */
    private $datePayement;

    /**
     * @ORM\Column(type="boolean")
     */
    private $TVA;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Payement", inversedBy="payes")
     */
    private $payement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypePayement", inversedBy="payes")
     */
    private $typepayement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypePayement", inversedBy="payements")
     */
    private $typePayement;

    /**
     * @ORM\Column(type="float")
     */
    private $montant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MotifPayement", inversedBy="payes")
     */
    private $motifPayement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $refPayement;

    public function __construct()
    {
        //$this->payement = new ArrayCollection();
        //$this->typePayement = new ArrayCollection();
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

    public function getPayement()
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

    public function getTypePayement()
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

    public function setPayement(?Payement $payement): self
    {
        $this->payement = $payement;

        return $this;
    }

    public function setTypepayement(?TypePayement $typepayement): self
    {
        $this->typepayement = $typepayement;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getMotifPayement(): ?MotifPayement
    {
        return $this->motifPayement;
    }

    public function setMotifPayement(?MotifPayement $motifPayement): self
    {
        $this->motifPayement = $motifPayement;

        return $this;
    }

    public function getRefPayement(): ?string
    {
        return $this->refPayement;
    }

    public function setRefPayement(?string $refPayement): self
    {
        $this->refPayement = $refPayement;

        return $this;
    }
}
