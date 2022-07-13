<?php
namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LivraisonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

 #[ApiResource(
    normalizationContext:[
        "groups"=>["Livraison:read"]
    ],  
   /*  denormalizationContext: 
    [
    "groups" => ["Livraison:write"]
    ] */
    
    collectionOperations:
            [
                "get"=>["method"=>"get"],"post"
            ],
            itemOperations:
            [
                "put","get"=>["path"=>"/livraisons/{id}"],"patch"
            ])
         ]
                                                               #[ORM\Entity(repositoryClass: LivraisonRepository::class)]
                                                               class Livraison
                                                               {
                                                                   #[ORM\Id]
                                                                   #[ORM\GeneratedValue]
                                                                   #[ORM\Column(type: 'integer')]
                                                                   #[Groups("Livraison:read")]
                                                                   private $id;
                                                               
                                                                   #[Groups("Livraison:read")]
                                                                   #[ORM\Column(type: 'float')]
                                                                   private $prixLivraison;
                                                               
                                                                   #[Groups("Livraison:read")]
                                                                   #[ORM\Column(type: 'date')]
                                                                   private $duree;
                                                               
                                                                   #[Groups("Livraison:read","Livraison:write")]
                                                                   #[ORM\ManyToOne(targetEntity: Livreur::class, inversedBy: 'livraisons')]
                                                                   #[ORM\JoinColumn(nullable: false)]
                                                                   private $livreur;
                                                               
                                                                   #[Groups("Livraison:read","Livraison:write")]
                                                                   #[ORM\OneToMany(mappedBy: 'livraison', targetEntity: Commande::class)]
                                                                   private $commande;
                                                            
                                                                   #[Groups("Livraison:read")]
                                                                   #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'livraisons')]
                                                                   private $gestionnaire;
                                                   
                                                                   #[Groups("Livraison:read","Livraison:write")]
                                                                   #[ORM\Column(type: 'string', length: 255)]
                                                                   private $etat;
            
                                                                   #[Groups("Livraison:read","Livraison:write")]
                                                                   #[ORM\ManyToMany(targetEntity: Zone::class)]
                                                                   private $zones;
                           
                                                                   public function __construct()
                                                                   {
                                                                      $this->duree=new \DateTime();
                                                                       $this->commande = new ArrayCollection();
                                                                       $this->zones = new ArrayCollection();
                                                                   }
                                                               
                                                                   public function getId(): ?int
                                                                   {
                                                                       return $this->id;
                                                                   }
                                                               
                                                                   public function getPrixLivraison(): ?float
                                                                   {
                                                                       return $this->getTotalCommande()+$this->getTotalZone();
                                                                   }
                                                               
                                                                   public function setPrixLivraison(float $prixLivraison): self
                                                                   {
                                                                       $this->prixLivraison = $prixLivraison;
                                                               
                                                                       return $this;
                                                                   }
                                                               
                                                                   public function getDuree(): ?\DateTimeInterface
                                                                   {
                                                                       return $this->duree;
                                                                   }
                                                               
                                                                   public function setDuree(\DateTimeInterface $duree): self
                                                                   {
                                                                       $this->duree = $duree;
                                                               
                                                                       return $this;
                                                                   }
                                                               
                                                            
                                                               
                                                                   public function getLivreur(): ?Livreur
                                                                   {
                                                                       return $this->livreur;
                                                                   }
                                                               
                                                                   public function setLivreur(?Livreur $livreur): self
                                                                   {
                                                                       $this->livreur = $livreur;
                                                               
                                                                       return $this;
                                                                   }
                                                               
                                                                   /**
                                                                    * @return Collection<int, Commande>
                                                                    */
                                                                   public function getCommande(): Collection
                                                                   {
                                                                       return $this->commande;
                                                                   }
                                                               
                                                                   public function addCommande(Commande $commande): self
                                                                   {
                                                                       if (!$this->commande->contains($commande)) {
                                                                           $this->commande[] = $commande;
                                                                           $commande->setLivraison($this);
                                                                       }
                                                               
                                                                       return $this;
                                                                   }
                                                               
                                                                   public function removeCommande(Commande $commande): self
                                                                   {
                                                                       if ($this->commande->removeElement($commande)) {
                                                                           // set the owning side to null (unless already changed)
                                                                           if ($commande->getLivraison() === $this) {
                                                                               $commande->setLivraison(null);
                                                                           }
                                                                       }
                                                               
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
                                                    
                                 
                                                                   public function getEtat(): ?string
                                                                   {
                                                                       return $this->etat;
                                                                   }
                              
                                                                   public function setEtat(string $etat): self
                                                                   {
                                                                       $this->etat = $etat;
                              
                                                                       return $this;
                                                                   }
      
                                                                   /**
                                                                    * @return Collection<int, Zone>
                                                                    */
                                                                   public function getZones(): Collection
                                                                   {
                                                                       return $this->zones;
                                                                   }
   
                                                                   public function addZone(Zone $zone): self
                                                                   {
                                                                       if (!$this->zones->contains($zone)) {
                                                                           $this->zones[] = $zone;
                                                                       }
   
                                                                       return $this;
                                                                   }

                                                                   public function removeZone(Zone $zone): self
                                                                   {
                                                                       $this->zones->removeElement($zone);

                                                                       return $this;
                                                                   }
                     
                                                                   public function getTotalCommande()
                                                                   {
                                                                        { return array_reduce($this->commande->toArray(),function($totalcommande,$commande)
                                                                            {
                                                                                return $totalcommande + $commande->getPrix();
                                                                            },0);
                                                                        } 
                                                                   }
                                                      
                                                                   public function getTotalZone()
                                                                   {
                                                                        { return array_reduce($this->zones->toArray(),function($totalzone,$zones)
                                                                            {
                                                                                //dd($zones);
                                                                                return $totalzone + $zones->getPrix();
                                                                            },0);
                                                                        } 
                                                                   }
                                                                  
                                                               }
