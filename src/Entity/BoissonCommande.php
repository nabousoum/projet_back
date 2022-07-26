<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BoissonCommandeRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: BoissonCommandeRepository::class)]
#[ApiResource()]
class BoissonCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["com:write"])]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(["com:write"])]
    #[Assert\Positive(message:'la quantite doit etre egal au moins a 1')]
    private $quantite=1;

    #[ORM\ManyToOne(targetEntity: BoissonTailleBoisson::class, inversedBy: 'boissonCommandes')]
    #[Groups(["com:write","com:read:simple"])]
    private $boissonTailleBoisson;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'boissonCommandes')]
    private $commande;

    #[ORM\Column(type: 'float')]
    private $prix;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBoissonTailleBoisson(): ?BoissonTailleBoisson
    {
        return $this->boissonTailleBoisson;
    }

    public function setBoissonTailleBoisson(?BoissonTailleBoisson $boissonTailleBoisson): self
    {
        $this->boissonTailleBoisson = $boissonTailleBoisson;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
}
