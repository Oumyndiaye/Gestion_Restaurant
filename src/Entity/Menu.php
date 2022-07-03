<?php

namespace App\Entity;

use App\Entity\Burger;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

 #[ApiResource (  
     normalizationContext:[
        "groups"=>["Menu:read"]
    ],
        denormalizationContext:[
            "groups"=>["Menu:write"]
        ],
     
     collectionOperations: [
        "post",
        'get' => ['method' => 'get']
    ],
    itemOperations: [
        'get' => [
            'path' => '/menus'            
        ],
    ] 
    
                                 
)]
#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu extends Produit
{
    public function __construct()
    {
        parent::__construct();
        $this->burgers = new ArrayCollection();
        $this->frittes = new ArrayCollection();
        $this->boissons = new ArrayCollection();
    }
    #[Groups(["Menu:read","Menu:write"])]
    #[ORM\ManyToMany(targetEntity: Burger::class, inversedBy: 'menus')]
    private $burgers;

    #[Groups(["Menu:read","Menu:write"])]
    #[ORM\ManyToMany(targetEntity: Fritte::class, inversedBy: 'menus')]
    private $frittes;

    #[Groups(["Menu:read","Menu:write"])]
    #[ORM\ManyToMany(targetEntity: Boisson::class, inversedBy: 'menus')]
    private $boissons;
    
    public function prixBurger()
    {
        return array_reduce($this->burgers->toArray(),function($totalBurger,$burger){
          return $totalBurger + $burger->getPrix();
        },0);
    } 
    public function prixFritte()
    {
       // dd($this->frittes->toArray());
        return array_reduce($this->frittes->toArray(),function($totalFritte,$fritte){
          return $totalFritte + $fritte->getPrix();
        },0);
    }

    public function prixBoisson()
    {
        return array_reduce($this->boissons->toArray(),function($totalBoisson,$boisson){
          return $totalBoisson + $boisson->getPrix();
        },0);
    }
    #[Groups(["Menu:read"])]
    #[SerializedName("prix")]
    public function getPrixMenu(){
        return $this->prixBurger() + $this->prixBoisson() + $this->prixFritte();
        
    }
    /**
     * @return Collection<int, Burger>
     */
    public function getBurgers(): Collection
    {
        return $this->burgers;
    }

    public function addBurger(Burger $burger): self
    {
        if (!$this->burgers->contains($burger)) {
            $this->burgers[] = $burger;
        }

        return $this;
    }

    public function removeBurger(Burger $burger): self
    {
        $this->burgers->removeElement($burger);

        return $this;
    }

    /**
     * @return Collection<int, Fritte>
     */
    public function getFrittes(): Collection
    {
        return $this->frittes;
    }

    public function addFritte(Fritte $fritte): self
    {
        if (!$this->frittes->contains($fritte)) {
            $this->frittes[] = $fritte;
        }

        return $this;
    }

    public function removeFritte(Fritte $fritte): self
    {
        $this->frittes->removeElement($fritte);

        return $this;
    }

    /**
     * @return Collection<int, Boisson>
     */
    public function getBoissons(): Collection
    {
        return $this->boissons;
    }

    public function addBoisson(Boisson $boisson): self
    {
        if (!$this->boissons->contains($boisson)) {
            $this->boissons[] = $boisson;
        }

        return $this;
    }

    public function removeBoisson(Boisson $boisson): self
    {
        $this->boissons->removeElement($boisson);

        return $this;
    }
   

   
}
