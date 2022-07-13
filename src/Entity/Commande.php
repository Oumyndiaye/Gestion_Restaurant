<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

 #[ApiResource(
    normalizationContext:
    [
    "groups" => ["Commande:read"]
    ],
    denormalizationContext: 
    [
    "groups" => ["Commande:write"]
    ]
    , 
    collectionOperations:
    [
    "get","post"
    ],
    itemOperations:
    [
    "put","get"
    ], 
    )
    ]
    #[ORM\Entity(repositoryClass: CommandeRepository::class)]
    class Commande
    {
    #[ORM\Id]
    #[Groups("Commande:read")]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups("Commande:read","Commande:write")]
    #[ORM\Column(type: 'string', length: 255)]
    private $etat;

    #[Groups("Commande:read","Commande:write")]
    #[ORM\Column(type: 'date')]
    private $date;

    #[ORM\JoinColumn(nullable: false)]
    #[Groups("Commande:read","Commande:write")]
    #[ORM\Column(type: 'float')]
    private $prix; 

    //#[Groups("Commande:read","Commande:write")]
    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commande')]
    private $livraison;

    #[Groups("Commande:read","Commande:write")]
    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private $client;

    #[Groups("Commande:read","Commande:write")]
    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: true)]
    private $gestionnaire;

    #[Groups("Commande:read","Commande:write")]
    #[ORM\ManyToOne(targetEntity: Livreur::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: true)]
    private $liveur;

    #[SerializedName("produits")]
    #[Groups("Commande:write","Commande:read")]
    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: LigneDeCommande::class,cascade:["persist"])]
    private $ligneDeCommandes;

    public function __construct()
    {
    $this->ligneDeCommandes = new ArrayCollection();
    }

    #[Groups(["Commande:read"])]
    #[SerializedName("prix")]
    public function  getPrixCommande()
    {
    return $this->prixLigneCommande() ;
    }                  

    public function prixLigneCommande()
    { return array_reduce($this->ligneDeCommandes->toArray(),function($totalligneDeCommandes,$ligneDeCommandes){
    return $totalligneDeCommandes + $ligneDeCommandes->getProduit()->getPrix();
    },0);
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

    public function getPrix(): ?float
    {
    return $this->prix;
    }

    public function setPrix(float $prix): self
    {
    $this->prix = $prix;

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
} 
