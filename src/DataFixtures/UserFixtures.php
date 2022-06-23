<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Driver\IBMDB2\Exception\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       
        // $manager->persist($product);

        $manager->flush();
    }
}
