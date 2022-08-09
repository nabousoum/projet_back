<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\BoissonTailleBoissonRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BoissonTailleBoissonRepository::class)]
#[ApiResource()]
class BoissonTailleBoisson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["com:write","detail"])]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(["burger:read:all","write","burger:read:simple","detail"])]
    private $stock;

    #[ORM\ManyToOne(targetEntity: Boisson::class, inversedBy: 'boissonTailleBoissons')]
    #[Groups("detail")]
    private $boisson;

    #[ORM\ManyToOne(targetEntity: TailleBoisson::class, inversedBy: 'boissonTailleBoissons')]
    #[Groups(["burger:read:all","write","burger:read:simple"])]
    private $tailleBoisson;

    #[ORM\OneToMany(mappedBy: 'boissonTailleBoisson', targetEntity: BoissonCommande::class)]
    private $boissonCommandes;

    #[ORM\OneToMany(mappedBy: 'boissonTailles', targetEntity: CommandeMenuBoissonTaille::class)]
    private $commandeMenuBoissonTailles;

    public function __construct()
    {
        $this->boissonCommandes = new ArrayCollection();
        $this->commandeMenuBoissonTailles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getBoisson(): ?Boisson
    {
        return $this->boisson;
    }

    public function setBoisson(?Boisson $boisson): self
    {
        $this->boisson = $boisson;

        return $this;
    }

    public function getTailleBoisson(): ?TailleBoisson
    {
        return $this->tailleBoisson;
    }

    public function setTailleBoisson(?TailleBoisson $tailleBoisson): self
    {
        $this->tailleBoisson = $tailleBoisson;

        return $this;
    }

    /**
     * @return Collection<int, BoissonCommande>
     */
    public function getBoissonCommandes(): Collection
    {
        return $this->boissonCommandes;
    }

    public function addBoissonCommande(BoissonCommande $boissonCommande): self
    {
        if (!$this->boissonCommandes->contains($boissonCommande)) {
            $this->boissonCommandes[] = $boissonCommande;
            $boissonCommande->setBoissonTailleBoisson($this);
        }

        return $this;
    }

    public function removeBoissonCommande(BoissonCommande $boissonCommande): self
    {
        if ($this->boissonCommandes->removeElement($boissonCommande)) {
            // set the owning side to null (unless already changed)
            if ($boissonCommande->getBoissonTailleBoisson() === $this) {
                $boissonCommande->setBoissonTailleBoisson(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommandeMenuBoissonTaille>
     */
    public function getCommandeMenuBoissonTailles(): Collection
    {
        return $this->commandeMenuBoissonTailles;
    }

    public function addCommandeMenuBoissonTaille(CommandeMenuBoissonTaille $commandeMenuBoissonTaille): self
    {
        if (!$this->commandeMenuBoissonTailles->contains($commandeMenuBoissonTaille)) {
            $this->commandeMenuBoissonTailles[] = $commandeMenuBoissonTaille;
            $commandeMenuBoissonTaille->setBoissonTailles($this);
        }

        return $this;
    }

    public function removeCommandeMenuBoissonTaille(CommandeMenuBoissonTaille $commandeMenuBoissonTaille): self
    {
        if ($this->commandeMenuBoissonTailles->removeElement($commandeMenuBoissonTaille)) {
            // set the owning side to null (unless already changed)
            if ($commandeMenuBoissonTaille->getBoissonTailles() === $this) {
                $commandeMenuBoissonTaille->setBoissonTailles(null);
            }
        }

        return $this;
    }
}
