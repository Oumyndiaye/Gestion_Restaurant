<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MenuTailleFritteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenuTailleFritteRepository::class)]
/* #[ApiResource(normalizationContext:[
    "groups"=>["Menu:read"]
],
    denormalizationContext:[
        "groups"=>["Menu:write"]
    ],)] */
class MenuTailleFritte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(["Menu:write","Menu:read"])]
    #[ORM\Column(type: 'float')]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuTailleFrittes')]
    #[ORM\JoinColumn(nullable: false)]
    private $menu;

    #[Groups(["Menu:write","Menu:read"])]
    #[ORM\ManyToOne(targetEntity: Fritte::class, inversedBy: 'menuTailleFrittes')]
    private $tailleFritte;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?float
    {
        return $this->quantite;
    }

    public function setQuantite(float $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    public function getTailleFritte(): ?Fritte
    {
        return $this->tailleFritte;
    }

    public function setTailleFritte(?Fritte $tailleFritte): self
    {
        $this->tailleFritte = $tailleFritte;

        return $this;
    }
}
