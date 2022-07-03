<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FritteRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    normalizationContext: 
    [
        "groups" => ["Fritte:read"]
    ],
    denormalizationContext: 
    [
        "groups" => ["Fritte:write"]
    ],
    /* collectionOperations: [
        'get' => ['method' => 'get'],
        'post'
    ],
    itemOperations: [
        'get' => [
            'path' => '/frittes'            
        ],
    ], */
  )
]
#[ORM\Entity(repositoryClass: FritteRepository::class)]
class Fritte extends Produit
{
    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'frittes')]
    private $menus;

    public function __construct()
    {
        parent::__construct();
        $this->menus = new ArrayCollection();
    }

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->addFritte($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removeFritte($this);
        }

        return $this;
    }
}
