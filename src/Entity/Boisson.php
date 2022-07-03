<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

 #[ApiResource(
                   collectionOperations: [
                       'get' => ['method' => 'get'],
                       "post"
                   ],
                   itemOperations: [
                       'get' => [
                           'path' => '/boissons'            
                       ],
                   ],
                               normalizationContext:
                                   [
                                       "groups"=>["Boisson:read"]
                                   ],
                               denormalizationContext:
                                   [
                                       "groups"=>["Boisson:write"]
                                   ],
                                   )
               
               ]
               #[ORM\Entity(repositoryClass: BoissonRepository::class)]
               class Boisson extends Produit
               {
               
               
                   #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'boissons')]
                   private $menus;
            
                   #[ORM\ManyToMany(targetEntity: TailleBoisson::class, mappedBy: 'boissons')]
                   private $tailleBoissons;
               
                   public function __construct()
                   {
                       parent::__construct();
                       $this->menus = new ArrayCollection();
                       $this->tailleBoissons = new ArrayCollection();
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
                               $menu->addBoisson($this);
                           }
               
                           return $this;
                       }
               
                       public function removeMenu(Menu $menu): self
                       {
                           if ($this->menus->removeElement($menu)) {
                               $menu->removeBoisson($this);
                           }
               
                           return $this;
                       }
      
                       /**
                        * @return Collection<int, TailleBoisson>
                        */
                       public function getTailleBoissons(): Collection
                       {
                           return $this->tailleBoissons;
                       }
   
                       public function addTailleBoisson(TailleBoisson $tailleBoisson): self
                       {
                           if (!$this->tailleBoissons->contains($tailleBoisson)) {
                               $this->tailleBoissons[] = $tailleBoisson;
                               $tailleBoisson->addBoisson($this);
                           }
   
                           return $this;
                       }

                       public function removeTailleBoisson(TailleBoisson $tailleBoisson): self
                       {
                           if ($this->tailleBoissons->removeElement($tailleBoisson)) {
                               $tailleBoisson->removeBoisson($this);
                           }

                           return $this;
                       }
               }
