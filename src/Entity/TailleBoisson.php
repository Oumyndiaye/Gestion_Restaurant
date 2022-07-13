<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TailleBoissonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TailleBoissonRepository::class)]
#[ApiResource(
    collectionOperations:
 [
    "get","post",
               ],
itemOperations:
[
    "put","get"
], 
/* normalizationContext:
[
    "groups" => ["TailleBoisson:read"]
],
denormalizationContext: 
[
    "groups" => ["TailleBoisson:write"]
] */)]
class TailleBoisson 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("TailleBoisson:write","TailleBoisson:read")]
    private $id;

    
    #[ORM\Column(type: 'string', length: 255)]
    private $taille;

    
    #[ORM\ManyToMany(targetEntity: Boisson::class, inversedBy: 'tailleBoissons')]
    private $boissons;

    #[ORM\ManyToMany(targetEntity: Menu::class, inversedBy: 'tailleBoissons')]
    private $menus;
 
    #[Groups("TailleBoisson:write","TailleBoisson:read")]
    #[ORM\Column(type: 'string')]
    private $prix; 

    #[ORM\OneToMany(mappedBy: 'tailleBoisson', targetEntity: MenuTailleBoisson::class)]
    private $menuTailleBoissons;

    public function __construct()
    {
        $this->boissons = new ArrayCollection();
        $this->menus = new ArrayCollection();
        $this->menuTailleBoissons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(string $taille): self
    {
        $this->taille = $taille;

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
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        $this->menus->removeElement($menu);

        return $this;
    }

   
    /**
     * @return Collection<int, MenuTailleBoisson>
     */
    public function getMenuTailleBoissons(): Collection
    {
        return $this->menuTailleBoissons;
    }

    public function addMenuTailleBoisson(MenuTailleBoisson $menuTailleBoisson): self
    {
        if (!$this->menuTailleBoissons->contains($menuTailleBoisson)) {
            $this->menuTailleBoissons[] = $menuTailleBoisson;
            $menuTailleBoisson->setTailleBoisson($this);
        }

        return $this;
    }

    public function removeMenuTailleBoisson(MenuTailleBoisson $menuTailleBoisson): self
    {
        if ($this->menuTailleBoissons->removeElement($menuTailleBoisson)) {
            // set the owning side to null (unless already changed)
            if ($menuTailleBoisson->getTailleBoisson() === $this) {
                $menuTailleBoisson->setTailleBoisson(null);
            }
        }

        return $this;
    }

    /**
     * Get the value of prix
     */ 
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set the value of prix
     *
     * @return  self
     */ 
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }
}
