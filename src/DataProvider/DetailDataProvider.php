<?php


namespace App\DataProvider;

use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use App\Repository\BoissonRepository;
use App\Repository\PortionFriteRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Detail;
use App\Entity\Menu;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use App\Entity\Burger;

final class DetailDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    
    
    public function __construct(BoissonRepository $boissonRepo,PortionFriteRepository $fritesRepo,MenuRepository $menuRepo,BurgerRepository $burgerRepo)
    {
       $this->boissonRepo = $boissonRepo;
       $this->fritesRepo = $fritesRepo;
       $this->menuRepo = $menuRepo;
       $this->burgerRepo = $burgerRepo;
      
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Detail::class === $resourceClass;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?Detail
    {
       $detail = new Detail();
        $detail->id = $id;
       $detail->portionFrites = $this->fritesRepo->findBy(['etat'=>'disponible']);
       $detail->tailleBoissons = $this->boissonRepo->findBy(['etat'=>'disponible']);
       
       return $detail;
    }
}