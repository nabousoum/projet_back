<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\DetailRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
#[ApiResource(
    itemOperations:[
        "get"=>[
        'method' => 'get',
        'status' => Response::HTTP_OK,
        'normalization_context' => ['groups' => ['detail']],
        ]]
)]

class Detail
{

    #[Groups(["detail"])]
    public ?int $id;

    #[Groups(["detail"])]
    public ?Menu $menu;
  
    #[Groups(["detail"])]
    public ?Burger $burger;

    #[Groups(["detail"])]
    public array $portionFrites;

     #[Groups(["detail"])]
    public array $tailleBoissons;

    public function __construct()
    {
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    public function getBurger(): ?Burger
    {
        return $this->burger;
    }

    public function setBurger(?Burger $burger): self
    {
        $this->burger = $burger;

        return $this;
    }

    /**
     * @return Collection<int, PortionFrite>
     */
    public function getPortionFrites(): array
    {
        return $this->portionFrites;
    }

    /**
     * @return Collection<int, TailleBoisson>
     */
    public function getTailleBoissons(): array
    {
        return $this->tailleBoissons;
    }

    
}
