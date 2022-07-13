<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\ControllerPersonnaliséController;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"type",type:"string")]
#[ORM\DiscriminatorMap(["GESTIONNAIRE"=>Gestionnaire::class,"CLIENT"=>Client::class,"LIVREUR"=>Livreur::class])] 
#[ApiResource(
   
    itemOperations:
        [
            "put","get"
        ],
    collectionOperations:
        [
            "post","get",
            "EmailValidation"=>[
                "method"=>"patch",
                "deserialize"=>false,
                "path"=>"/users/validate/{token}",
                "controller"=>ControllerPersonnaliséController::class
            ]
        ])
]
class User implements UserInterface,PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;
    

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    protected $email;

   
    #[ORM\Column(type: 'json')]
    protected $roles = [];

    #[ORM\Column(type: 'string', length: 255)]
    protected $password;
    
    #[ORM\Column(type: 'string',length: 255)]
    protected $nom;

    
    #[ORM\Column(type: 'string', length: 255)]
    protected $prenom;

    #[SerializedName("password")]
    protected $plainPassword;

    #[ORM\Column(type: 'string', length: 255)]
    protected $token;

    #[ORM\Column(type: 'boolean')]
    protected $isEnable;

    #[ORM\Column(type: 'datetime')]
    protected $expireAt;


    public function __construct()
    {
       $this-> isEnable=false;
       $this-> generateToken();
        
    }
    public function generateToken()
    {
            $this-> expireAt = new \DateTime("+1 day" ) ;
            $this->token = bin2hex(openssl_random_pseudo_bytes(16)); 
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
  

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
         $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function isIsEnable(): ?bool
    {
        return $this->isEnable;
    }

    public function setIsEnable(bool $isEnable): self
    {
        $this->isEnable = $isEnable;

        return $this;
    }

    public function getExpireAt(): ?\DateTimeInterface
    {
        return $this->expireAt;
    }

    public function setExpireAt(\DateTimeInterface $expireAt): self
    {
        $this->expireAt = $expireAt;

        return $this;
    }
}
