<?php


namespace App\DataProvider;

use App\Entity\Catalogue;
use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use App\Entity\Detail;

final class DetailDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    
    
    public function __construct()
    {
      
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        dd('ok');
        return Detail::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        return "ok";
    }
}