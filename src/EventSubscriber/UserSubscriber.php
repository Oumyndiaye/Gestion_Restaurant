<?php

namespace App\EventSubscriber;

use App\Entity\Menu;
use App\Entity\Burger;
use App\Entity\Fritte;
use App\Entity\Boisson;
use App\Entity\Client;
use App\Entity\Livraison;
use App\Entity\Livreur;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserSubscriber implements EventSubscriberInterface
{
    
    private  ?TokenInterface $token;
    
    public function __construct(TokenStorageInterface $tokenStorage,EntityManagerInterface $manager)
    {
      $this->token = $tokenStorage->getToken();
    }
    
    public static function getSubscribedEvents(): array
    {
        return [
            Events::prePersist
        ];
    }

   
         private function getUser()
        {
        //dd($this->token);
        if (null === $token = $this->token) {
        return null;
        }
        if (!is_object($user = $token->getUser())) {
        // e.g. anonymous authentication
        return null;
        }
        return $user;
        }

        public function prePersist(LifecycleEventArgs $args)
        {
            if ($args->getObject() instanceof Burger || $args->getObject() instanceof Livreur || $args->getObject() instanceof Boisson || $args->getObject() instanceof Fritte || $args->getObject() instanceof Menu ||  $args->getObject() instanceof Livraison ||  $args->getObject() instanceof Produit ) 
            {
                $args->getObject()->setGestionnaire($this->getUser());
            }
        }

          
}
