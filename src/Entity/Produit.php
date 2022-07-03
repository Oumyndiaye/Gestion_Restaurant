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
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap(["menu" =>"Menu" , "burger" => "Burger","complement" => "Complement","fritte" => "Fritte","boisson" => "Boisson"])]
#[ApiResource(
     collectionOperations:
        [
            "get","post",
        ],
    itemOperations:
        [
            "put"
        ], 
    normalizationContext:
        [
            "groups" => ["Produit:read"]
        ],
    denormalizationContext: 
        [
            "groups" => ["Produit:write"]
        ])
]

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
/**
 * @ORM\Entity
 * @Uploadable
 */
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("Menu:read")]
    protected $id;


    #[Groups(["Produit:read", "Produit:write","Menu:write","Menu:read","Burger:read","Burger:write","Fritte:read","Fritte:write","Boisson:read","Boisson:write"])]
    #[ORM\Column(type: 'string', length: 255)]
    
    protected $nom;

    #[Groups(["Produit:read", "Produit:write", "Menu:read","Burger:read","Burger:write","Fritte:read","Fritte:write","Boisson:read","Boisson:write"])]
    #[ORM\Column(type: 'object')]
    protected $image;

   /*  #[SerializedName("image")]
    protected $photo; */

    #[Groups(["Produit:read", "Produit:write","Menu:write","Menu:read","Burger:read","Burger:write","Fritte:read","Fritte:write","Boisson:read","Boisson:write"])]
    #[ORM\Column(type: 'string', length: 255)]
    protected $etat;

    #[ORM\Column(type: 'float')]
    #[Groups(["Produit:read", "Produit:write","Menu:write","Menu:read","Burger:read","Burger:write","Fritte:read","Fritte:write","Boisson:read","Boisson:write"])]
    protected $prix;
  

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: LigneDeCommande::class)]
    protected $ligneDeCommandes;

    #[Groups([ "Produit:write", "Boisson:write","Menu:write","Burger:write","Fritte:write"])]
    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    protected $Gestionnaire;

    #[ORM\ManyToMany(targetEntity: Commande::class, inversedBy: 'produits')]
    private $commandes;

    /**
     * @UploadableField(mapping="produits_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

      /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

    public function __construct()
    {
        $this->ligneDeCommandes = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->updatedAt=new \DateTime();
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

    public function getImage(): ?object
    {
        return $this->image;
    }

    public function setImage(object $image): self
    {
        $this->image = $image;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        $this->commandes->removeElement($commande);

        return $this;
    }

    
   

   

    /**
     * Get the value of imageFile
     *
     * @return  File
     */ 
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Set the value of imageFile
     *
     * @param  File  $imageFile
     *
     * @return  self
     */ 
    public function setImageFile(File $imageFile=null)
    {
        $this->imageFile = $imageFile;
      /*   if ($imageFile) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        } */

        return $this;
    }
}
