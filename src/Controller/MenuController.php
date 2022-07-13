<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\TailleBoisson;
use App\Repository\BoissonRepository;
use App\Repository\BurgerRepository;
use App\Repository\FritteRepository;
use App\Repository\MenuRepository;
use App\Repository\TailleBoissonRepository;
use ArrayObject;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    
    
    public function __invoke(Request $request,BurgerRepository $repo,EntityManagerInterface $manager,FritteRepository $rep,TailleBoissonRepository $re)
    {
        $content=json_decode($request->getContent());  
      $menu=new Menu;
      if (isset($content->burgers) && isset($content->frittes) && isset($content->boissons)) 
        {
            
            foreach ($content->burgers as $b  )
            {
               
                $burger=$repo->find($b->burger);
                //dd($repo->find($b->burger));
                        $prixBurger=$burger->getPrix()*$b->quantite;
                        $menu->addBurger($burger,$b->quantite);
                    
            }

            foreach ($content->frittes as $f)
            {
                
                        $frite=$rep->find($f->fritte);
                        $prixFritte=$frite->getPrix()*$f->quantite;
                        $menu->addFritte($frite,$f->quantite);
                    
            }

            foreach ($content->boissons as $b)
            {
                    
                        $boisson=$re->find($b->boisson);
                        $boissonPrix=$boisson->getPrix()*$b->quantite;
                        $menu->addBoisson($boisson,$b->quantite);
                    
            }
           // dd($menu);
                $menu->setNom("rawane");
                $menu->setImage('menu');
                $menu->setEtat("disponible");
                $prixMenu=$prixBurger+$prixFritte+$boissonPrix;
                $menu->setPrix($prixMenu);
                $manager->persist($menu);
                $manager->flush(); 
            }
    }
}


