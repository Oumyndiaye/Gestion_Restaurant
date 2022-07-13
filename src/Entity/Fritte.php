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
    collectionOperations:[
        'get',
        'post' => [
            'input_formats' => [
                'multipart' => ['multipart/form-data'],
             ],    
        ]
        
            ],
            itemOperations: [
                'get',
                'delete'
            ], 
    /* ,
     collectionOperations: [
        'get' => ['method' => 'get'],
        'post'
    ],
    itemOperations: [
        'get' => [
            'path' => '/frittes'            
        ],
        'delete'
    ],  */
   
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
        //$this->menus = new ArrayCollection();
    }
 
}
