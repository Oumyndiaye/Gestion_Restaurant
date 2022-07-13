<?php
namespace App\Entity;
use App\Entity\Burger;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Controller\MenuController;
use Doctrine\Common\Collections\ArrayCollection;
use phpDocumentor\Reflection\Types\Nullable;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
#[ApiResource (  
   normalizationContext:[
        "groups"=>["Menu:read"]
   ],
  /*  denormalizationContext:[
    "groups"=>["Menu:write"]
], */
collectionOperations: [
   'get'=>["method"=>"get"],
    'post' => [
        "path"=>"/menus",
            'method'=>'post',
             /* 'denormalization_context'=>[ 'groups'=> ['Menu:write'] ], */
        // 'input_formats' => [
        //     'multipart' => ['multipart/form-data'],
           
    ]/* , 
    "addMenu"=>[
        "method"=>"post",
        "path"=>"/menu2",
        "controller"=>MenuController::class,
        "validate"=>false,
        "deserialize"=>false
    ]    */
],
    itemOperations: 
    ['delete','get' ] 
 )]    
#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu extends Produit
{
    public function __construct()
    {
        parent::__construct();
        // $this->burgers = new ArrayCollection();
        //$this->frittes = new ArrayCollection();
        //$this->boissons = new ArrayCollection();
        //$this->tailleBoissons = new ArrayCollection();
        $this->menuBurgers = new ArrayCollection();
        $this->menuTailleBoissons = new ArrayCollection();
        $this->menuTailleFrittes = new ArrayCollection();
    }

    #[Groups(['Menu:write','Menu:read'])]
    protected $nom;

    #[Groups(['Menu:write','Menu:read'])]
    protected $image;

    #[Groups(["Menu:read","Menu:write"])] 
    #[SerializedName("burgers")]
    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuBurger::class,cascade:['persist'])]
    private $menuBurgers;

    #[SerializedName("boissons")]
    #[Groups(["Menu:read","Menu:write"])]
    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuTailleBoisson::class)]
    private $menuTailleBoissons;

    #[SerializedName("frittes")]
    #[Groups(["Menu:read","Menu:write"])]
    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuTailleFritte::class)]
    private $menuTailleFrittes;

    

   /* public function prixBoisson()
    {
        return array_reduce($this->tailleBoissons->toArray(),function($totalTailleBoisson,$tailleBoissons){
        return $totalTailleBoisson + $tailleBoissons->getPrix();
        },0);
    } 


    public function prixFritte()
    {
        dd($this->frittes);
        return array_reduce($this->frittes->toArray(),function($totalFritte,$frittes){
        return $totalFritte + $frittes->getPrix();
        },0);
    } 

     

      #[Groups(["Menu:write"])]
    #[SerializedName("prix")]
    #[ORM\JoinColumn(nullable: true)]
    public function getPrixMenu()
    {
        return   $this->prixFritte() + $this->prixBoisson();
    }  */
    
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
            $menuBurger->setMenu($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getMenu() === $this) {
                $menuBurger->setMenu(null);
            }
        }

        return $this;
    }

    /**
        * @return Collection<int, Burger>
    */
    public function addBurger(Burger $burger, int $quantite): self
    {
        $MenuBurger=new MenuBurger();
        $MenuBurger->setMenu($this);
        $MenuBurger->setQuantite($quantite);
        $MenuBurger->setBurgers($burger);
        $this->addMenuBurger($MenuBurger);
             return $this;
    }

    public function addFritte(Fritte $fritte,int $quantite):self 
    {
        $frite=new MenuTailleFritte();
        $frite->setMenu($this);
        $frite->setQuantite($quantite);
        $frite->setTailleFritte($fritte);
            $this->addMenuTailleFritte($frite);
            return $this;
    }

    public function addBoisson(TailleBoisson $boisson, int $quantite):self
    {
        $boisso=new MenuTailleBoisson();
        $boisso->setMenu($this);
        $boisso->setQuantite($quantite);
        $boisso->setTailleBoisson($boisson);
            $this->addMenuTailleBoisson($boisso);
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
            $menuTailleBoisson->setMenu($this);
        }

        return $this;
    }

    public function removeMenuTailleBoisson(MenuTailleBoisson $menuTailleBoisson): self
    {
        if ($this->menuTailleBoissons->removeElement($menuTailleBoisson)) {
            // set the owning side to null (unless already changed)
            if ($menuTailleBoisson->getMenu() === $this) {
                $menuTailleBoisson->setMenu(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, MenuTailleFritte>
     */
    public function getMenuTailleFrittes(): Collection
    {
        return $this->menuTailleFrittes;
    }

    public function addMenuTailleFritte(MenuTailleFritte $menuTailleFritte): self
    {
        if (!$this->menuTailleFrittes->contains($menuTailleFritte)) {
            $this->menuTailleFrittes[] = $menuTailleFritte;
            $menuTailleFritte->setMenu($this);
        }

        return $this;
    }

    public function removeMenuTailleFritte(MenuTailleFritte $menuTailleFritte): self
    {
        if ($this->menuTailleFrittes->removeElement($menuTailleFritte)) {
            // set the owning side to null (unless already changed)
            if ($menuTailleFritte->getMenu() === $this) {
                $menuTailleFritte->setMenu(null);
            }
        }
        return $this;
    } 
}
