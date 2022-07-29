<?php


namespace App\DataProvider;

use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Detail;
use App\Entity\Menu;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;

final class DetailDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    
    
    public function __construct(MenuRepository $menuRepository, BurgerRepository $burgerRepository)
    {
        
      
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Detail::class === $resourceClass;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?Detail
    {
        $detail  = new Detail();
        $detail->setMenu(new Menu());
        return $detail;
    }
}