<?php

namespace App\EventSubscriber;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Serializer\SerializerInterface;
class ProduitSubscriber implements EventSubscriberInterface
{

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        //$this->serializer = $serializer;
    }

    public static function getSubscribedEvents()
    {
        return [
            Events::prePersist
        ];
    }
    
    public function prePersist(LifecycleEventArgs $args)
    {
        if ($args->getObject() instanceof Produit ) 
        
        {
                dd('lkjhh');
                $photo=$this->base64url_encode($args->getObject()->getPhoto());
                dd($photo);
                //$photoJson=$serializer->denormalize($photo,'json');
                $args->getObject()->setImage($photo);
                $this->manager->persist($args->getObject());
                $this->manager->flush();
        }
    }

        function base64url_encode( $data )
        {
            return rtrim( strtr( base64_encode( $data ), '+/', '-_'), '=');
        }
}