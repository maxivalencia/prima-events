<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypePayementRepository")
 */
class TypePayement
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
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Paye", inversedBy="typePayement")
     */
    private $paye;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Paye", mappedBy="typepayement")
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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
        return $this->getType();
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
            $paye->setTypepayement($this);
        }

        return $this;
    }

    public function removePaye(Paye $paye): self
    {
        if ($this->payes->contains($paye)) {
            $this->payes->removeElement($paye);
            // set the owning side to null (unless already changed)
            if ($paye->getTypepayement() === $this) {
                $paye->setTypepayement(null);
            }
        }

        return $this;
    }
}
