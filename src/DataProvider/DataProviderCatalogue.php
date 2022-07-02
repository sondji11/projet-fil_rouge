<?php
// api/src/DataProvider/BlogPostCollectionDataProvider.php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Catalogue;
use App\Repository\BurgerRepository;
use App\Repository\MenuRepository;

final class DataProviderCatalogue implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private BurgerRepository $burger;
    private MenuRepository $menu;

    public function __construct(BurgerRepository $burger ,MenuRepository $menu)
    {
       
        $this->burger=$burger;

        $this->menu=$menu;
   
        
    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
     
        return Catalogue::class === $resourceClass;
    }
    
    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
       
        // dd($this->burger->findAll());

        // Retrieve the blog post collection from somewhere
        if(Catalogue::class==$resourceClass)
        {
            return[
                ["burger"=>$this->burger->findAll()],
                ["menu" =>$this->menu->findAll()]
            ];
        } 
    }
}