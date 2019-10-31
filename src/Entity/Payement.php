<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PayementRepository")
 */
class Payement
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
    private $mode;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Paye", inversedBy="payement")
     */
    private $paye;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Paye", mappedBy="payement")
     */
    private $payes;

    public function __construct()
    {
        $this->payes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMode(): ?string
    {
        return $this->mode;
    }

    public function setMode(string $mode): self
    {
        $this->mode = $mode;

        return $this;
    }

    public function getPaye(): ?Paye
    {
        return $this->paye;
    }

    public function setPaye(?Paye $paye): self
    {
        $this->paye = $paye;

        return $this;
    }

    /**
     * toString
     * @return string
     */
    public function __toString()
    {
        return $this->getMode();
    }

    /**
     * @return Collection|Paye[]
     */
    public function getPayes(): Collection
    {
        return $this->payes;
    }

    public function addPaye(Paye $paye): self
    {
        if (!$this->payes->contains($paye)) {
            $this->payes[] = $paye;
            $paye->setPayement($this);
        }

        return $this;
    }

    public function removePaye(Paye $paye): self
    {
        if ($this->payes->contains($paye)) {
            $this->payes->removeElement($paye);
            // set the owning side to null (unless already changed)
            if ($paye->getPayement() === $this) {
                $paye->setPayement(null);
            }
        }

        return $this;
    }
}
