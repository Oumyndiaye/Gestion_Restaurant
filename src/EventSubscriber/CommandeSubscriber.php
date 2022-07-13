<?php

namespace App\EventSubscriber;

use App\Entity\Commande;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class CommandeSubscriber implements EventSubscriberInterface
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
            if ($args->getObject() instanceof Commande) 
            {
                //dd('hfff');
                $args->getObject()->setClient($this->getUser());
            }
        }
}