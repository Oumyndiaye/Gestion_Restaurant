<?php
namespace App\DataProvider;

use App\Entity\Complement; 
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use App\Repository\BoissonRepository;
use App\Repository\FritteRepository;

final class ComplementCollectionDataProvider implements ContextAwareCollectionDataProviderInterface,RestrictedDataProviderInterface{
     public function __construct(FritteRepository $repo1,BoissonRepository $repo2){
            $this->repo1=$repo1;
            $this->repo2=$repo2;
     }
    
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Complement::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        // Retrieve the blog post collection from somewhere
        //yield new Fritte;
        //yield new Boisson;
       $complement= [$fritte=$this->repo1->findAll(),$boison=$this->repo2->findAll()];
        return $complement;
        
      
    }
}