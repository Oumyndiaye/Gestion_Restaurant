<?php
namespace App\DataPersister;
use App\Entity\Menu;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Doctrine\ORM\EntityManagerInterface;
class DataPersisterMenu implements ContextAwareDataPersisterInterface
{
    public function __construct(EntityManagerInterface $manager){
        
       $this->manager = $manager;
    }

    public function supports($data,$context=[]):bool
    {
        return  $data instanceof Menu;
    }
/**
 *  @Menu $data
 */
    public function persist($data,$context=[])
    {
        $data->setPrix($data-> getPrixMenu()); 
        $photo=$data->getPhoto()->getRealPath();
        $photo= stream_get_contents(fopen($photo,"rb"));
        $data->setImage($photo);
        $this->manager->persist($data);
        $this->manager->flush();
    }

    public function remove($data,$context=[])
    {
      
    }
    
}