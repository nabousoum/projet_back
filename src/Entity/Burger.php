<?php

namespace App\Entity;

use App\Entity\Menu;
use App\Entity\Produit;
use App\Entity\Catalogue;
use App\Entity\Gestionnaire;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
        'method' => 'get',
        'status' => Response::HTTP_OK,
        'normalization_context' => ['groups' => ['burger:read:simple']],
        ]
    ,"post"=>[
        'denormalization_context' => ['groups' => ['write']],
        'normalization_context' => ['groups' => ['burger:read:all']],
        "security"=>"is_granted('ROLE_GESTIONNAIRE')",
        "security_message"=>"Vous n'avez pas access à cette Ressource",
        'input_formats' => [
            'multipart' => ['multipart/form-data'],
        ]
    ]],
    itemOperations:["put"=>[
        "security"=>"is_granted('ROLE_GESTIONNAIRE')",
        "security_message"=>"Vous n'avez pas access à cette Ressource",
    ],
    "get"=>[
        'method' => 'get',
        'status' => Response::HTTP_OK,
        'normalization_context' => ['groups' => ['burger:read:all']],
        ],
    "delete"=>[
        "security"=>"is_granted('ROLE_GESTIONNAIRE')",
        "security_message"=>"Vous n'avez pas access à cette Ressource",
        ]
    ],
  
)]
class Burger extends Produit
{
    private $catalogue;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'burgers')]
    #[Groups(["write"])]
    private $gestionnaire;

    #[ORM\OneToMany(mappedBy: 'burger', targetEntity: MenuBurger::class)]
    private $menuBurgers;

    #[ORM\OneToMany(mappedBy: 'burger', targetEntity: BurgerCommande::class)]
    private $burgerCommandes;


    private Collection $details;



    public function __construct()
    {
        $this->menuBurgers = new ArrayCollection();
        $this->burgerCommandes = new ArrayCollection();
        $this->type = 'burger';
        $this->details = new ArrayCollection();
    }

    public function getCatalogue(): ?Catalogue
    {
        return $this->catalogue;
    }

    public function setCatalogue(?Catalogue $catalogue): self
    {
        $this->catalogue = $catalogue;

        return $this;
    }

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    /**
     * @return Collection<int, MenuBurger>
     */
    public function getMenuBurgers(): Collection
    {
        return $this->menuBurgers;
    }

    public function addMenuBurger(MenuBurger $menuBurger): self
    {
        if (!$this->menuBurgers->contains($menuBurger)) {
            $this->menuBurgers[] = $menuBurger;
            $menuBurger->setBurger($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getBurger() === $this) {
                $menuBurger->setBurger(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BurgerCommande>
     */
    public function getBurgerCommandes(): Collection
    {
        return $this->burgerCommandes;
    }

    public function addBurgerCommande(BurgerCommande $burgerCommande): self
    {
        if (!$this->burgerCommandes->contains($burgerCommande)) {
            $this->burgerCommandes[] = $burgerCommande;
            $burgerCommande->setBurger($this);
        }

        return $this;
    }

    public function removeBurgerCommande(BurgerCommande $burgerCommande): self
    {
        if ($this->burgerCommandes->removeElement($burgerCommande)) {
            // set the owning side to null (unless already changed)
            if ($burgerCommande->getBurger() === $this) {
                $burgerCommande->setBurger(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Detail>
     */
    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetail(Detail $detail): self
    {
        if (!$this->details->contains($detail)) {
            $this->details->add($detail);
            $detail->setBurger($this);
        }

        return $this;
    }

    public function removeDetail(Detail $detail): self
    {
        if ($this->details->removeElement($detail)) {
            // set the owning side to null (unless already changed)
            if ($detail->getBurger() === $this) {
                $detail->setBurger(null);
            }
        }

        return $this;
    }

   
}
