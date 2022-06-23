<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ControllerPersonnaliséController extends AbstractController
{
    public function __invoke(Request $request,UserRepository $repo,EntityManagerInterface $manager)
    {
        $token=$request->get("token");
        $user=$repo->findOneBy(["token"=>$token]);
        if(!$user){
         return  new JsonResponse(["error"=>"token invalide"],Response::HTTP_BAD_REQUEST );
        }
        if ($user->isIsEnable()) {
            return new JsonResponse(['message'=>"ce compte est déjà activé"],Response::HTTP_BAD_REQUEST);
        }
        if(($user->getExpireAt()) < new \DateTime()){
            return new JsonResponse(['message'=>"ce compte n'est plus valide"],Response::HTTP_BAD_REQUEST);

        }
         $user->setIsEnable(true);
        $manager->flush();
    }
}
