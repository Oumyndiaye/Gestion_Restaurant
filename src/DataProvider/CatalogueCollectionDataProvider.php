<?php

namespace App\DataProvider;
use App\Entity\Catalogue;
use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use App\Repository\FritteRepository;
use App\Repository\BoissonRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

final class CatalogueCollectionDataProvider implements ContextAwareCollectionDataProviderInterface,RestrictedDataProviderInterface
{
    public function __construct(FritteRepository $repo1,BoissonRepository $repo2,MenuRepository $repo3,BurgerRepository $repo4)
    {
        /*    $this->repo1=$repo1;
           $this->repo2=$repo2; */
           $this->repo3=$repo3;
           $this->repo4=$repo4;
    }
   
   public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
   {
       return Catalogue::class === $resourceClass;
   }

   public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
   {
       // Retrieve the blog post collection from somewhere
       //yield new Fritte;
       //yield new Boisson;
      $catalogue= [$this->repo3->findAll(),$this->repo4->findAll()];
       return $catalogue; 
   }
}