<?php

namespace App\Entity;

use App\Repository\MouvementRepository;
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
     * @ORM\Column(type="integer")
     */
    private $quantite;

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

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="stocks")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="stocks")
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Mouvement", inversedBy="stocks")
     */
    private $mouvement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="stocks")
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Mode", inversedBy="stocks")
     */
    private $mode;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="stocksortie")
     */
    private $userSortie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="stockretour")
     */
    private $userRetour;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Fournisseur", inversedBy="stocks")
     */
    private $Location;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantiteLouer;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbJour;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateDeValidationProformat;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        //$this->article = new ArrayCollection();
        //$this->mouvement = new ArrayCollection();
        $this->client = new ArrayCollection();
        $this->mode = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    
    public function getUser()
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
    
    public function getArticle()
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

    public function getMouvement(): ?Mouvement
    {
        return $this->mouvement;
    }

    /* public function addMouvement(Mouvement $mouvement): self
    {
        if (!$this->mouvement->contains($mouvement)) {
            $this->mouvement[] = $mouvement;
            $mouvement->setStock($this);
        }

        return $this;
    } */

    /* public function removeMouvement(Mouvement $mouvement): self
    {
        if ($this->mouvement->contains($mouvement)) {
            $this->mouvement->removeElement($mouvement);
            // set the owning side to null (unless already changed)
            if ($mouvement->getStock() === $this) {
                $mouvement->setStock(null);
            }
        }

        return $this;
    } */

    
    public function getClient()
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

    public function getMode()
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

    public function setUser(?Utilisateur $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function setMouvement(?Mouvement $mouvement): self
    {
        $this->mouvement = $mouvement;

        return $this;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function setMode(?Mode $mode): self
    {
        $this->mode = $mode;

        return $this;
    }

    public function getUserSortie(): ?Utilisateur
    {
        return $this->userSortie;
    }

    public function setUserSortie(?Utilisateur $userSortie): self
    {
        $this->userSortie = $userSortie;

        return $this;
    }

    public function getUserRetour(): ?Utilisateur
    {
        return $this->userRetour;
    }

    public function setUserRetour(?Utilisateur $userRetour): self
    {
        $this->userRetour = $userRetour;

        return $this;
    }

    public function getLocation(): ?Fournisseur
    {
        return $this->Location;
    }

    public function setLocation(?Fournisseur $Location): self
    {
        $this->Location = $Location;

        return $this;
    }

    public function getQuantiteLouer(): ?int
    {
        return $this->quantiteLouer;
    }

    public function setQuantiteLouer(?int $quantiteLouer): self
    {
        $this->quantiteLouer = $quantiteLouer;

        return $this;
    }

    public function getNbJour(): ?int
    {
        return $this->nbJour;
    }

    public function setNbJour(?int $nbJour): self
    {
        $this->nbJour = $nbJour;

        return $this;
    }

    public function getDateDeValidationProformat(): ?\DateTimeInterface
    {
        return $this->dateDeValidationProformat;
    }

    public function setDateDeValidationProformat(?\DateTimeInterface $dateDeValidationProformat): self
    {
        $this->dateDeValidationProformat = $dateDeValidationProformat;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }
}
