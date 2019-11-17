<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Utilisateur;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoleRepository")
 */
class Role
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
    private $role;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Utilisateur", mappedBy="Utilisateur")
     */
    private $utilisateurs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Utilisateur", mappedBy="role")
     */
    private $utilisateurid;

    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();
        $this->utilisateurid = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?string
    {
        return strtoupper($this->role);
    }

    public function setRole(string $role): self
    {
        $this->role = strtoupper($role);

        return $this;
    }

    /**
     * @return Collection|Utilisateur[]
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): self
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs[] = $utilisateur;
            $utilisateur->setRole($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        if ($this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->removeElement($utilisateur);
            // set the owning side to null (unless already changed)
            if ($utilisateur->getRole() === $this) {
                $utilisateur->setRole(null);
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
        return $this->getRole();
    }

    /**
     * @return Collection|Utilisateur[]
     */
    public function getUtilisateurid(): Collection
    {
        return $this->utilisateurid;
    }

    public function addUtilisateurid(Utilisateur $utilisateurid): self
    {
        if (!$this->utilisateurid->contains($utilisateurid)) {
            $this->utilisateurid[] = $utilisateurid;
            $utilisateurid->setRole($this);
        }

        return $this;
    }

    public function removeUtilisateurid(Utilisateur $utilisateurid): self
    {
        if ($this->utilisateurid->contains($utilisateurid)) {
            $this->utilisateurid->removeElement($utilisateurid);
            // set the owning side to null (unless already changed)
            if ($utilisateurid->getRole() === $this) {
                $utilisateurid->setRole(null);
            }
        }

        return $this;
    }
}
