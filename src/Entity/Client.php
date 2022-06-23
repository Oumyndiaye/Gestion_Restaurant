<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
//use Symfony\Component\Mailer\MailerInterface;

 
#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource(
        
          normalizationContext:[
            "groups"=>["Client:read"]
        ],
            denormalizationContext:[
                "groups"=>["Client:write"]
             ]
        )]
        
class Client extends User
{
     public function __construct()
    {
        parent::__construct();
        $this->roles=["ROLE_CLIENT"];
    } 

    #[Groups(["Client:read","Client:write"])]
    #[ORM\Column(type: 'string', length: 255)] 
    private $numeroTelephone;

    

    public function getNumeroTelephone(): ?string
    {
        return $this->numeroTelephone;
    }

    public function setNumeroTelephone(string $numeroTelephone): self
    {
        $this->numeroTelephone = $numeroTelephone;

        return $this;
    }
}
