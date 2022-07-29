<?php


namespace App\DataProvider;

use App\Entity\Catalogue;
use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use App\Entity\Detail;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;

final class DetailDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    
    
    public function __construct()
    {
      
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Detail::class === $resourceClass;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?Detail
    {
        dd($id);
    }
}