<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
  #[ApiResource(
    collectionOperations:[
        "GET"=>[
            "path"=>"/catalogues"]
    ],
    itemOperations:[])
]  
class Catalogue
{
   
   
}
