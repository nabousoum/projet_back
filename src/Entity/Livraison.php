<?php

namespace App\Entity;

use App\Entity\Commande;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivraisonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            'normalization_context' => ['groups' => ['livraison:read:all']],
            // "security" => "is_granted('LIVRAISON_ALL',_api_resource_class)", 
        ],
        "post_register" => [
            "security_post_denormalize" => "is_granted('LIVRAISON_CREATE', object)",
            "method"=>"post",
            'normalization_context' => ['groups' => ['livraison:read:simple']],
            'denormalization_context' => ['groups' => ['livraison:write']]
        ]
        ],itemOperations:["put"=>[
            "security" => "is_granted('LIVRAISON_EDIT', object)",
            'denormalization_context' => ['groups' => ['livraison:put']]
        ],
            "get"=>[
                'method' => 'get',
                'status' => Response::HTTP_OK,
                'normalization_context' => ['groups' => ['livraison:read:all']]
            ]
        ]
)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["livraison:write","livraison:read:simple","livraison:read:all"])]
    private $id;

    #[ORM\Column(type: 'float')]
    #[Groups(["livraison:write","livraison:read:simple","livraison:read:all"])]
    private $montantTotal;

    #[ORM\ManyToOne(targetEntity: Livreur::class, inversedBy: 'livraisons')]
    #[Groups(["livraison:write","livraison:read:simple","livraison:read:all"])]
    private $livreur;

    #[ORM\OneToMany(mappedBy: 'livraison', targetEntity: Commande::class)]
    #[Groups(["livraison:write","livraison:read:simple","livraison:read:all"])]
    #[ApiSubresource]
    private $commandes;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["livraison:write","livraison:read:simple","livraison:read:all",'livraison:put'])]
    private ?string $etat = "en cours";

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantTotal(): ?float
    {
        return $this->montantTotal;
    }

    public function setMontantTotal(float $montantTotal): self
    {
        $this->montantTotal = $montantTotal;

        return $this;
    }

    public function getLivreur(): ?Livreur
    {
        return $this->livreur;
    }

    public function setLivreur(?Livreur $livreur): self
    {
        $this->livreur = $livreur;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setLivraison($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getLivraison() === $this) {
                $commande->setLivraison(null);
            }
        }

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}
