<?php
namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use ApiPlatform\Core\Filter\Validator\Length;
use App\Entity\Commande;
use App\Entity\Livraison;
use App\Entity\Livreur;
use App\Entity\Produit;
use App\Entity\Quartier;
use App\Entity\Zone;
use Doctrine\ORM\EntityManagerInterface;


class DataPersisterArchiver implements ContextAwareDataPersisterInterface
{
    public function __construct(EntityManagerInterface $manager){
        $this->manager = $manager;
     }
 
     public function supports($data,$context=[]):bool
     {
         return  $data instanceof Commande || $data  instanceof Livreur || $data  instanceof Livraison   ;
     }

     public function persist($data,$context=[])
     {

                if ($data instanceof Commande) 
                    {
                        $data->setPrix($data->getPrixCommande()) ;
                        $data->setEtat("indisponible");
                            $data->setDate(new \DateTime('now'));
                            $this->manager->persist($data);
                            $this->manager->flush(); 
                    }
                    elseif ( $data  instanceof Livraison )
                     {
                        $data->setEtat("indisponible");
                        $data->setPrixLivraison($data->getPrixLivraison());
                        $this->manager->persist($data);
                        $this->manager->flush(); 
                    }
                else
                    {
                            $data->setEtat("indisponible");
                            $data->setDate(new \DateTime('now'));
                            $this->manager->persist($data);
                            $this->manager->flush(); 
                    } 
     }
 
     public function remove($data,$context=[])
     {
        if ( $data->getEtat()==='disponible')
        {
            $data->setEtat("disponible");
            $this->manager->persist($data);
            $this->manager->flush();  
        } else if($data->getEtat()==='indisponible') {
            $data->setEtat("indisponible");
            $this->manager->persist($data);
            $this->manager->flush();  
        }
        
     }
}