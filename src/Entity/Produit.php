<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap(["menu" =>"Menu" , "burger" => "Burger","complement" => "Complement","fritte" => "Fritte","boisson" => "Boisson"])]
#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ApiResource(
     collectionOperations:
        [
            "get",
            'post' => [
                /* 'input_formats' => [
                    'multipart' => ['multipart/form-data'],
                ], */    
            ]
        ],
    itemOperations:
        [
            "put","get"
        ], 
  /*   normalizationContext:
        [
            "groups" => ["Produit:read"]
        ],
        
      denormalizationContext: 
        [
            "groups" => ["Produit:write"]
        ]  */ )
]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups(["Fritte:read","Fritte:write","Menu:read","Menu:write","Boisson:read","Boisson:write"])]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[Groups(["Fritte:read","Fritte:write","Boisson:read","Boisson:write"])]
    #[ORM\Column(type: 'string', length: 255)]
     protected $nom;
    
    #[ORM\Column(type: 'blob',nullable:true)]
    protected $image;

    #[SerializedName("image")]
    protected $photo; 

    #[ORM\Column(type: 'string', length: 255)]
    protected $etat;

    #[ORM\Column(type: 'float',nullable:true)]
    #[Groups(["Produit:read", "Produit:write","Fritte:read","Fritte:write","Boisson:read","Boisson:write"])]
    protected $prix;

    #[Groups([ "Produit:write", "Boisson:write","Burger:write"])]
    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    protected $Gestionnaire;

     #[ORM\OneToMany(mappedBy: 'produit', targetEntity: LigneDeCommande::class)]
     private $ligneDeCommandes; 


     public function __construct()
    {
       
    } 

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
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


     public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    } 

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->Gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $Gestionnaire): self
    {
        $this->Gestionnaire = $Gestionnaire;

        return $this;
    }

    /**
     * Get the value of photo
     */ 
    public function getPhoto()
    {
        
        return $this->photo;
    }

    /**
     * Set the value of photo
     *
     * @return  self
     */ 
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    public function getImage():?string
    {
        return $this->image;

        //return(string) $this->image;
    
        //return (is_resource($this->image) ? base64_encode( stream_get_contents($this->image)) : $this->image);
    }

    public function setImage($image): self
    {
        $this->image = $image;

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
            $ligneDeCommande->setProduit($this);
        }

        return $this;
    }

    public function removeLigneDeCommande(LigneDeCommande $ligneDeCommande): self
    {
        if ($this->ligneDeCommandes->removeElement($ligneDeCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneDeCommande->getProduit() === $this) {
                $ligneDeCommande->setProduit(null);
            }
        }

        return $this;
    }
}
