<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
//use Symfony\Component\Mailer\MailerInterface;

 
#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource(
    /* collectionOperations:
        [
            "get","post",
        ],
    itemOperations:
        [
            "put", "get"
        ],
        
          normalizationContext:[
            "groups"=>["Client:read"]
        ],
            denormalizationContext:[
                "groups"=>["Client:write"]
             ] */
        )]
        
class Client extends User
{
     public function __construct()
    {
        parent::__construct();
        $this->roles=["ROLE_CLIENT"];
        $this->commandes = new ArrayCollection();
    } 

    #[Groups(["Client:read","Client:write"])]
    #[ORM\Column(type: 'string', length: 255)] 
    private $numeroTelephone;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Commande::class)]
    private $commandes;

    public function getNumeroTelephone(): ?string
    {
        return $this->numeroTelephone;
    }

    public function setNumeroTelephone(string $numeroTelephone): self
    {
        $this->numeroTelephone = $numeroTelephone;

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
            $commande->setClient($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getClient() === $this) {
                $commande->setClient(null);
            }
        }

        return $this;
    }
}
