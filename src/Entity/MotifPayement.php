<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MotifPayementRepository")
 */
class MotifPayement
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
    private $motif;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Paye", mappedBy="motifPayement")
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

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): self
    {
        $this->motif = $motif;

        return $this;
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
            $paye->setMotifPayement($this);
        }

        return $this;
    }

    public function removePaye(Paye $paye): self
    {
        if ($this->payes->contains($paye)) {
            $this->payes->removeElement($paye);
            // set the owning side to null (unless already changed)
            if ($paye->getMotifPayement() === $this) {
                $paye->setMotifPayement(null);
            }
        }

        return $this;
    }

    /**
     * toString
     * @return string
     */
    public function __toString()
    {
        return $this->getMotif();
    }
}
