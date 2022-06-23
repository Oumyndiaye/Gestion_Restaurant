<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonRepository;
use ApiPlatform\Core\Annotation\ApiResource;
/**
 *@ORM\Entity(repositoryClass="App\Repository\UserRepository")) 
 * @ApiResource 
 * / */
 #[ApiResource ]
#[ORM\Entity(repositoryClass: BoissonRepository::class)]
class Boisson extends Complement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $variete;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVariete(): ?string
    {
        return $this->variete;
    }

    public function setVariete(string $variete): self
    {
        $this->variete = $variete;

        return $this;
    }
}
