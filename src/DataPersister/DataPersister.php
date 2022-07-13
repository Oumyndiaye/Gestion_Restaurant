<?php
namespace App\DataPersister;
use App\Entity\User;
use App\Services\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

 class DataPersister implements ContextAwareDataPersisterInterface
 {
   
     public function __construct(UserPasswordHasherInterface $encoder,EntityManagerInterface $manager,Mailer $mailer)
     {
        $this->encoder=$encoder;
        $this->manager=$manager;
        $this->mailer=$mailer;
     } 
     public function supports($data,$context=[]):bool
    {
        return $data instanceof User;
    } 
    
      public function persist($data,$context=[])
    {
        if($data->getPlainPassword())
        {
            $password=$this->encoder->hashPassword($data,$data->getPlainPassword());
            $data->setPassword($password);
            $data->eraseCredentials();
            $this->manager->persist($data);
            $this->manager->flush();
            $this->mailer->sendEmail($data,"creation de compte");
        } 
    }   
     public function remove($data,$context=[])
    {
        
    } 

} 