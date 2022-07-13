<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LigneDeCommandeRepository;
use Symfony\Component\Serializer\Annotation\Groups;
#[ORM\Entity(repositoryClass: LigneDeCommandeRepository::class)]

class LigneDeCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(["Commande:write","Commande:read","Menu:write","Menu:read"])]
    #[ORM\Column(type: 'float')]
    private $quantite;

    #[ORM\JoinColumn(nullable: true)]
    #[ORM\Column(type: 'float')]
    private $prix;

    #[Groups(["Commande:write","Commande:read"])]
    #[ORM\ManyToOne(targetEntity: Produit::class, inversedBy: 'ligneDeCommandes')]
    #[ORM\JoinColumn(nullable: false)]
    private $produit;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'ligneDeCommandes')]
    #[ORM\JoinColumn(nullable: false)]
    private $commande;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?float
    {
        return $this->quantite;
    }

    public function setQuantite(float $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prixDeVente = $prix;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    

   

}
