<?php
// api/src/DataProvider/BlogPostCollectionDataProvider.php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Complement;
use App\Repository\PortionfriteRepository;
use App\Repository\TailleRepository;

final class DataProviderComplement implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private PortionfriteRepository $portionfrite;
    private TailleRepository $taille;

    public function __construct(PortionfriteRepository $portionfrite,TailleRepository $taille)
    {
       
        $this->portionfrite=$portionfrite;

        $this->taille=$taille;
   
        
    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
     
        return Complement::class === $resourceClass;
    }
    
    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
       
        

        // Retrieve the blog post collection from somewhere
        if(Complement::class==$resourceClass)
        {
            return[
                ["portionfrite"=>$this->portionfrite->findAll()],
                ["taille" =>$this->taille->findAll()]
            ];
        } 
    }
}