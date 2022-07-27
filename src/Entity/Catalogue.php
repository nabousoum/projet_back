<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BurgerRepository;
use App\Repository\MenuRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;

// #[ORM\Entity(repositoryClass: CatalogueRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
        'method' => 'get',
        'status' => Response::HTTP_OK,
        'normalization_context' => ['groups' => ['catalogue:read:simple']],
        ]]
)]
class Catalogue
 {
//     #[ORM\Id]
//     #[ORM\GeneratedValue]
//     #[ORM\Column(type: 'integer')]
    private $id;

   
    #[Groups(["catalogue:read:simple"])]
    private $menus;

   
    #[Groups(["catalogue:read:simple"])]
    private $burgers;

    public function __construct(BurgerRepository $burgerRepo, MenuRepository $menuRepo)
    {
        $this->menus = $menuRepo->findBy(['etat'=>'disponible']);
        $this->burgers = $burgerRepo->findBy(['etat'=>'disponible']);
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getMenus()
    {
        return $this->menus;
    }


    public function getBurgers()
    {
        return $this->burgers;
    }

    
}
