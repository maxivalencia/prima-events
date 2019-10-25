<?php

namespace App\Entity;

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
}
