<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource (
    collectionOperations:[
        'get',
        'post' => [
            'input_formats' => [
                'multipart' => ['multipart/form-data'],
             ],    
        ]
    ],
    itemOperations: [
        'get' => [
            'path' => '/burgers'            
        ],
    ], 
    normalizationContext:
        [
            "groups"=>["Burger:read"]
        ],
    denormalizationContext:
        [
            "groups"=>["Burger:write"]
        ]
        )
]
#[ORM\Entity(repositoryClass: BurgerRepository::class)]
class Burger extends Produit
{
    #[Groups('Menu:write')]
    protected $id;
   
    #[ORM\OneToMany(mappedBy: 'burgers', targetEntity: MenuBurger::class)]
    private $menuBurgers;


    public function __construct()
    {
        parent::__construct();
        $this->menuBurgers = new ArrayCollection();
    }
    
   
    public function setMenuBurger(?MenuBurger $menuBurger): self
    {
        $this->menuBurger = $menuBurger;

        return $this;
    }

    /**
     * @return Collection<int, MenuBurger>
     */
    public function getMenuBurgers(): Collection
    {
        return $this->menuBurgers;
    }

    public function addMenuBurger(MenuBurger $menuBurger): self
    {
        if (!$this->menuBurgers->contains($menuBurger)) {
            $this->menuBurgers[] = $menuBurger;
            $menuBurger->setBurgers($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getBurgers() === $this) {
                $menuBurger->setBurgers(null);
            }
        }

        return $this;
    }

    

}
