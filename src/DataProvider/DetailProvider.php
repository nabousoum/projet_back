<?php


namespace App\DataProvider;

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
        return Detail::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        
    }
}