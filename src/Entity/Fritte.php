<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FritteRepository;
use ApiPlatform\Core\Annotation\ApiResource;
/**
 *@ORM\Entity(repositoryClass="App\Repository\UserRepository")) 
 * @ApiResource 
 * / */
 #[ApiResource ]
#[ORM\Entity(repositoryClass: FritteRepository::class)]
class Fritte extends Complement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $proportion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProportion(): ?string
    {
        return $this->proportion;
    }

    public function setProportion(string $proportion): self
    {
        $this->proportion = $proportion;

        return $this;
    }
}
