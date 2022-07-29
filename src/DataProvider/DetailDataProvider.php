<?php


namespace App\DataProvider;

use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use App\Repository\BoissonRepository;
use App\Repository\PortionFriteRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Detail;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use App\Repository\BoissonTailleBoissonRepository;

final class DetailDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{   
    public function __construct(BoissonTailleBoissonRepository $boissonRepo,PortionFriteRepository $fritesRepo,MenuRepository $menuRepo,BurgerRepository $burgerRepo)
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
        $menu = $this->menuRepo->findOneBy(array('id' => $id));
        $burger = $this->burgerRepo->findOneBy(array('id' => $id));
        //dd($burger);
       $detail = new Detail();
        if($menu == null){
            $detail->burger = $burger;
        }
        elseif($burger == null){
            $detail->menu = $menu;
        }
        $detail->id = $id;
       $detail->portionFrites = $this->fritesRepo->findBy(['etat'=>'disponible']);
       $detail->tailleBoissons = $this->boissonRepo->findAll();
       
       return $detail;
    }
}