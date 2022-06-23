<?php
namespace App\Services;

use App\Entity\User;
use Twig\Environment;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\twig;

class Mailer{

  public function __construct(MailerInterface $mailer,Environment $twig)
  {
   $this->twig=$twig;
    $this->mailer=$mailer;
  }
    /**
     * @param User $user
     */
     public function sendEmail($user,$subject="creation compte")
     {
        $email=(new Email());
        $email
        ->From("aaondiaye@gmail.com")
        ->To($user->getEmail())
        ->subject($subject)
        ->html(
            $this->twig->render("registration.html.twig",[
              "user"=>$user,
              "token"=>$user->getToken(),
              "subject"=>$subject]));
            $this->mailer->send($email);
     }  

}