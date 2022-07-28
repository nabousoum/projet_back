<?php


namespace App\DataProvider;

use App\Entity\Detail;
use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

final class DetailDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    
    private $detail;
    public function __construct(BurgerRepository $burgerRepo, MenuRepository $menuRepo)
    {
      $this->detail = new Detail($burgerRepo,$menuRepo);
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Detail::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
       $details = [];
       $details['menus'] =  $this->detail->getMenus();
       $details['burgers'] = $this->detail->getBurgers();
        return $details;
    }
}