<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
#[ApiResource(
    collectionOperations:[
        "GET"=>
            ["path"=>"/complements"]
    ],
    itemOperations:[])
] 
class Complement 
{
 
}
