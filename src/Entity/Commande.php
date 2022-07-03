<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

 #[ApiResource(collectionOperations:
    [
        "get","post",
    ],
    itemOperations:
    [
        "put"
    ])
]
#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $etat;

    #[ORM\Column(type: 'date')]
    private $date;

    #[ORM\Column(type: 'float')]
    private $prixCommande;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: LigneDeCommande::class)]
    private $ligneDeCommandes;

    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commande')]
    private $livraison;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private $client;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private $gestionnaire;

    #[ORM\ManyToOne(targetEntity: Livreur::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private $liveur;

    #[ORM\ManyToMany(targetEntity: Produit::class, mappedBy: 'commandes')]
    private $produits;

    public function __construct()
    {
    $this->ligneDeCommandes = new ArrayCollection();
    $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
    return $this->id;
    }

    public function getEtat(): ?string
    {
    return $this->etat;
    }

    public function setEtat(string $etat): self
    {
    $this->etat = $etat;

    return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
    return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
    $this->date = $date;

    return $this;
    }

    public function getPrixCommande(): ?float
    {
    return $this->prixCommande;
    }

    public function setPrixCommande(float $prixCommande): self
    {
    $this->prixCommande = $prixCommande;

    return $this;
    }

    /**
    * @return Collection<int, LigneDeCommande>
    */
    public function getLigneDeCommandes(): Collection
    {
    return $this->ligneDeCommandes;
    }

    public function addLigneDeCommande(LigneDeCommande $ligneDeCommande): self
    {
    if (!$this->ligneDeCommandes->contains($ligneDeCommande)) {
    $this->ligneDeCommandes[] = $ligneDeCommande;
    $ligneDeCommande->setCommande($this);
    }

    return $this;
    }

    public function removeLigneDeCommande(LigneDeCommande $ligneDeCommande): self
    {
    if ($this->ligneDeCommandes->removeElement($ligneDeCommande)) {
    // set the owning side to null (unless already changed)
    if ($ligneDeCommande->getCommande() === $this) {
    $ligneDeCommande->setCommande(null);
    }
    }

    return $this;
    }

    public function getLivraison(): ?Livraison
    {
    return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
    $this->livraison = $livraison;

    return $this;
    }

    public function getClient(): ?Client
    {
    return $this->client;
    }

    public function setClient(?Client $client): self
    {
    $this->client = $client;

    return $this;
    }

    public function getGestionnaire(): ?Gestionnaire
    {
    return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
    $this->gestionnaire = $gestionnaire;

    return $this;
    }

    public function getLiveur(): ?Livreur
    {
    return $this->liveur;
    }

    public function setLiveur(?Livreur $liveur): self
    {
    $this->liveur = $liveur;

    return $this;
    }

    /**
    * @return Collection<int, Produit>
    */
    public function getProduits(): Collection
    {
    return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
    if (!$this->produits->contains($produit)) {
    $this->produits[] = $produit;
    $produit->addCommande($this);
    }

    return $this;
    }

    public function removeProduit(Produit $produit): self
    {
    if ($this->produits->removeElement($produit)) {
    $produit->removeCommande($this);
    }

    return $this;
    }
} 
