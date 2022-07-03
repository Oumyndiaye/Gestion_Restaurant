<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\GestionnaireRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

 #[ApiResource(
    collectionOperations:
    [
        "get"=>[
            "method"=>"get",
        ],
        "post",
    ],
    itemOperations:
    [
        "get"=>[
            "path"=>"/gestionnaires"
        ],
        "put"
    ],
    normalizationContext:
    [
        "groups"=>["Gestionnaire:read"]
    ],
        denormalizationContext:
                [
            "groups"=>["Gestionnaire:write"]
                    ],
    subresourceOperations: [
        'api_produits_gestionnaires_get_subresource' => [
            'method' => 'GET',
            'path' => '/api/gestionnaires/{id}/produits',
        ],
        'api_livreurs_gestionnaires_get_subresource' => [
            'method' => 'GET',
            'path' => '/api/gestionnaires/{id}/livreurs',
        ],
    ]              
)]
                                                                             
               #[ORM\Entity(repositoryClass: GestionnaireRepository::class)]
               class Gestionnaire extends User
               {
                   #[ApiSubresource]
                   #[ORM\OneToMany(mappedBy: 'Gestionnaire', targetEntity: Produit::class)]
                   private $produits;
               
                   #[ApiSubresource] 
                   #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Livreur::class)]
                   private $livreurs;
               
                   #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Commande::class)]
                   private $commandes;
            
                   #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Livraison::class)]
                   private $livraisons;
               
                   public function __construct()
                   {
                       parent::__construct();
                       $this->produits = new ArrayCollection();
                       $this->roles=["ROLE_GESTIONNAIRE"];
                       $this->livreurs = new ArrayCollection();
                       $this->commandes = new ArrayCollection();
                       $this->livraisons = new ArrayCollection();
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
                           $produit->setGestionnaire($this);
                       }
               
                       return $this;
                   }
               
                   public function removeProduit(Produit $produit): self
                   {
                       if ($this->produits->removeElement($produit)) {
                           // set the owning side to null (unless already changed)
                           if ($produit->getGestionnaire() === $this) {
                               $produit->setGestionnaire(null);
                           }
                       }
               
                       return $this;
                   }
               
                   /**
                    * @return Collection<int, Livreur>
                    */
                   public function getLivreurs(): Collection
                   {
                       return $this->livreurs;
                   }
               
                   public function addLivreur(Livreur $livreur): self
                   {
                       if (!$this->livreurs->contains($livreur)) {
                           $this->livreurs[] = $livreur;
                           $livreur->setGestionnaire($this);
                       }
               
                       return $this;
                   }
               
                   public function removeLivreur(Livreur $livreur): self
                   {
                       if ($this->livreurs->removeElement($livreur)) {
                           // set the owning side to null (unless already changed)
                           if ($livreur->getGestionnaire() === $this) {
                               $livreur->setGestionnaire(null);
                           }
                       }
               
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
                           $commande->setGestionnaire($this);
                       }
               
                       return $this;
                   }
               
                   public function removeCommande(Commande $commande): self
                   {
                       if ($this->commandes->removeElement($commande)) {
                           // set the owning side to null (unless already changed)
                           if ($commande->getGestionnaire() === $this) {
                               $commande->setGestionnaire(null);
                           }
                       }
               
                       return $this;
                   }
      
                   /**
                    * @return Collection<int, Livraison>
                    */
                   public function getLivraisons(): Collection
                   {
                       return $this->livraisons;
                   }
   
                   public function addLivraison(Livraison $livraison): self
                   {
                       if (!$this->livraisons->contains($livraison)) {
                           $this->livraisons[] = $livraison;
                           $livraison->setGestionnaire($this);
                       }
   
                       return $this;
                   }

                   public function removeLivraison(Livraison $livraison): self
                   {
                       if ($this->livraisons->removeElement($livraison)) {
                           // set the owning side to null (unless already changed)
                           if ($livraison->getGestionnaire() === $this) {
                               $livraison->setGestionnaire(null);
                           }
                       }

                       return $this;
                   }
               }
