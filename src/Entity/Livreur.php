<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivreurRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

 #[ApiResource (
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
            "groups"=>["Gestionnaire:read"]
        ],
    denormalizationContext:
        [
            "groups"=>["Gestionnaire:write"]
        ])
]
    #[ORM\Entity(repositoryClass: LivreurRepository::class)]
class Livreur extends User
{
    #[Groups(["Gestionnaire:read","Gestionnaire:write"])]
    #[ORM\Column(type: 'string', length: 255)]
    private $etat;

    #[ORM\Column(type: 'string', length: 255)]
    private $matriculeMoto;

    #[ORM\OneToMany(mappedBy: 'livreur', targetEntity: Livraison::class)]
    private $livraisons;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'livreurs')]
    #[ORM\JoinColumn(nullable: false)]
    private $gestionnaire;

    #[ORM\OneToMany(mappedBy: 'liveur', targetEntity: Commande::class)]
    private $commandes;

    public function __construct()
    {
        parent::__construct();
        $this->matriculeMoto=date('Y', time()).'-'.sprintf("%05d", $this->id).'-M';
        $this->roles=["ROLE_LIVREUR"];
        $this->livraisons = new ArrayCollection();
        $this->commandes = new ArrayCollection();
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

    public function getMatriculeMoto(): ?string
    {
        return $this->matriculeMoto;
    }

    public function setMatriculeMoto(string $matriculeMoto): self
    {
        $this->matriculeMoto = $matriculeMoto;

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
            $livraison->setLivreur($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getLivreur() === $this) {
                $livraison->setLivreur(null);
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
            $commande->setLiveur($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getLiveur() === $this) {
                $commande->setLiveur(null);
            }
        }

        return $this;
    }
}
