<?php
namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use ApiPlatform\Core\DataPersister\ResumableDataPersisterInterface;
use App\Entity\Fritte;
use App\Entity\Menu;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
class DataPersisterMm implements ContextAwareDataPersisterInterface

{
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    } 
    
    //**
    /*@ $data Produit
     */
    public function supports($data, array $context = []): bool
    {
        
        return $data instanceof Produit;
    }

    public function persist($data, array $context = [])
    {
       //dd($data);
      $photo=$data->getPhoto()->getRealPath();
       $photo= stream_get_contents(fopen($photo,"rb"));
      $data->setImage($photo);
            $this->manager->persist($data);
            $this->manager->flush();
        
    }

    public function remove($data, array $context = [])
    {
        
    }
}