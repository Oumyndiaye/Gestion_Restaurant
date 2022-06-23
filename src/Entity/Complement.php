<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ComplementRepository;
use ApiPlatform\Core\Annotation\ApiResource;
/**
 *@ORM\Entity(repositoryClass="App\Repository\UserRepository")) 
 * @ApiResource 
 * / */
 #[ApiResource ]
#[ORM\Entity(repositoryClass: ComplementRepository::class)]
class Complement extends Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
