<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StockRepository")
 */
class Stock
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Utilisateur", mappedBy="stock")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="stock")
     */
    private $article;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Mouvement", mappedBy="stock")
     */
    private $mouvement;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Client", mappedBy="stock")
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Mode", mappedBy="stock")
     */
    private $mode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateCommande;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateSortiePrevue;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateSortieEffectif;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateRetourPrevu;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateRetourEffectif;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->article = new ArrayCollection();
        $this->mouvement = new ArrayCollection();
        $this->client = new ArrayCollection();
        $this->mode = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Utilisateur[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(Utilisateur $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setStock($this);
        }

        return $this;
    }

    public function removeUser(Utilisateur $user): self
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getStock() === $this) {
                $user->setStock(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->article->contains($article)) {
            $this->article[] = $article;
            $article->setStock($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->article->contains($article)) {
            $this->article->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getStock() === $this) {
                $article->setStock(null);
            }
        }

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * @return Collection|Mouvement[]
     */
    public function getMouvement(): Collection
    {
        return $this->mouvement;
    }

    public function addMouvement(Mouvement $mouvement): self
    {
        if (!$this->mouvement->contains($mouvement)) {
            $this->mouvement[] = $mouvement;
            $mouvement->setStock($this);
        }

        return $this;
    }

    public function removeMouvement(Mouvement $mouvement): self
    {
        if ($this->mouvement->contains($mouvement)) {
            $this->mouvement->removeElement($mouvement);
            // set the owning side to null (unless already changed)
            if ($mouvement->getStock() === $this) {
                $mouvement->setStock(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClient(): Collection
    {
        return $this->client;
    }

    public function addClient(Client $client): self
    {
        if (!$this->client->contains($client)) {
            $this->client[] = $client;
            $client->setStock($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->client->contains($client)) {
            $this->client->removeElement($client);
            // set the owning side to null (unless already changed)
            if ($client->getStock() === $this) {
                $client->setStock(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Mode[]
     */
    public function getMode(): Collection
    {
        return $this->mode;
    }

    public function addMode(Mode $mode): self
    {
        if (!$this->mode->contains($mode)) {
            $this->mode[] = $mode;
            $mode->setStock($this);
        }

        return $this;
    }

    public function removeMode(Mode $mode): self
    {
        if ($this->mode->contains($mode)) {
            $this->mode->removeElement($mode);
            // set the owning side to null (unless already changed)
            if ($mode->getStock() === $this) {
                $mode->setStock(null);
            }
        }

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(?\DateTimeInterface $dateCommande): self
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    public function getDateSortiePrevue(): ?\DateTimeInterface
    {
        return $this->dateSortiePrevue;
    }

    public function setDateSortiePrevue(?\DateTimeInterface $dateSortiePrevue): self
    {
        $this->dateSortiePrevue = $dateSortiePrevue;

        return $this;
    }

    public function getDateSortieEffectif(): ?\DateTimeInterface
    {
        return $this->dateSortieEffectif;
    }

    public function setDateSortieEffectif(?\DateTimeInterface $dateSortieEffectif): self
    {
        $this->dateSortieEffectif = $dateSortieEffectif;

        return $this;
    }

    public function getDateRetourPrevu(): ?\DateTimeInterface
    {
        return $this->dateRetourPrevu;
    }

    public function setDateRetourPrevu(?\DateTimeInterface $dateRetourPrevu): self
    {
        $this->dateRetourPrevu = $dateRetourPrevu;

        return $this;
    }

    public function getDateRetourEffectif(): ?\DateTimeInterface
    {
        return $this->dateRetourEffectif;
    }

    public function setDateRetourEffectif(?\DateTimeInterface $dateRetourEffectif): self
    {
        $this->dateRetourEffectif = $dateRetourEffectif;

        return $this;
    }
}
