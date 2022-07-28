<?php

namespace App\Entity;

use App\Repository\DetailRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


class Detail
{
   
    private $id;


    private Collection $burger;

    private Collection $menu;

    public function __construct()
    {
        $this->burgers = new ArrayCollection();
        $this->menus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

 
    public function getBurgers()
    {
        return $this->burgers;
    }


    public function getMenus()
    {
        return $this->menus;
    }

}
