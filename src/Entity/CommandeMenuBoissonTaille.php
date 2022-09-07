<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\CommandeMenuBoissonTailleRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ApiResource()]
#[ORM\Entity(repositoryClass: CommandeMenuBoissonTailleRepository::class)]
class CommandeMenuBoissonTaille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'commandeMenuBoissonTailles')]
    private $commandes;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'commandeMenuBoissonTailles')]
    private $menus;

    #[ORM\ManyToOne(targetEntity: BoissonTailleBoisson::class, inversedBy: 'commandeMenuBoissonTailles')]
    #[Groups(["com:write"])]
    private $boissonTailles;

    #[ORM\Column(type: 'integer')]
    #[Groups(["com:write"])]    
    private $quantite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommandes(): ?Commande
    {
        return $this->commandes;
    }

    public function setCommandes(?Commande $commandes): self
    {
        $this->commandes = $commandes;

        return $this;
    }

    public function getMenus(): ?Menu
    {
        return $this->menus;
    }

    public function setMenus(?Menu $menus): self
    {
        $this->menus = $menus;

        return $this;
    }

    public function getBoissonTailles(): ?BoissonTailleBoisson
    {
        return $this->boissonTailles;
    }

    public function setBoissonTailles(?BoissonTailleBoisson $boissonTailles): self
    {
        $this->boissonTailles = $boissonTailles;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

}
