<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            'normalization_context' => ['groups' => ['com:read:all']],
            // "security" => "is_granted('COMMANDE_ALL',_api_resource_class)", 
        ],
        "post_register" => [
            "security_post_denormalize" => "is_granted('COMMANDE_CREATE', object)",
            "method"=>"post",
            'normalization_context' => ['groups' => ['com:read:simple']],
            'denormalization_context' => ['groups' => ['com:write']]
        ]
        ],itemOperations:["put"=>[
           
        ],
            "get"=>[
                'method' => 'get',
                'status' => Response::HTTP_OK,
                'normalization_context' => ['groups' => ['com:read:all']]
            ]
        ]
            ),
           
]

class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["com:read:simple","com:read:all","livraison:write"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["com:read:simple","com:read:all","com:write","livraison:write","livraison:read:simple","livraison:read:all"])]
    private $numeroCommande;

    #[ORM\Column(type: 'datetime')]
    #[Groups(["com:read:simple","com:read:all","livraison:write","livraison:read:simple","livraison:read:all"])]
    private $dateCommande;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["com:read:simple","com:read:all","livraison:write","livraison:read:simple","livraison:read:all"])]
    private $etat="en cours";

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["com:read:simple","com:read:all","com:write","livraison:write","livraison:read:simple","livraison:read:all"])]
    private $montantCommande;

    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes')]
    private $livraison;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'commandes')]
    private $gestionnaire;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["com:write","com:read:all","com:write","livraison:write","livraison:read:simple","livraison:read:all"])]
    private $client;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'commandes')]
    #[Groups(["com:write","com:read:all","com:write","livraison:write","livraison:read:simple","livraison:read:all"])]
    private $zone;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: BurgerCommande::class,cascade:['persist'])]
    #[Groups(["com:read:simple","com:read:all","com:write"])]
    #[Assert\Valid]
    private $burgerCommandes;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: MenuCommande::class,cascade:['persist'])]
    #[Groups(["com:read:simple","com:read:all","com:write"])]
    #[Assert\Valid]
    private $menuCommandes;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: BoissonCommande::class,cascade:['persist'])]
    #[Groups(["com:read:simple","com:read:all","com:write"])]
    #[Assert\Valid]
    private $boissonCommandes;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: FriteCommande::class,cascade:['persist'])]
    #[Groups(["com:read:simple","com:read:all","com:write"])]
    #[Assert\Valid]
    private $friteCommandes;

    #[ORM\OneToMany(mappedBy: 'commandes', targetEntity: CommandeMenuBoissonTaille::class)]
    private $commandeMenuBoissonTailles;



    public function __construct()
    {
        $this->dateCommande = new \DateTime();
        $this->burgerCommandes = new ArrayCollection();
        $this->menuCommandes = new ArrayCollection();
        $this->boissonCommandes = new ArrayCollection();
        $this->friteCommandes = new ArrayCollection();
        $this->commandeMenuBoissonTailles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCommande(): ?string
    {
        return $this->numeroCommande;
    }

    public function setNumeroCommande(string $numeroCommande): self
    {
        $this->numeroCommande = $numeroCommande;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): self
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getMontantCommande(): ?string
    {
        return $this->montantCommande;
    }

    public function setMontantCommande(string $montantCommande): self
    {
        $this->montantCommande = $montantCommande;

        return $this;
    }

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

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
            $burgerCommande->setCommande($this);
        }

        return $this;
    }

    public function removeBurgerCommande(BurgerCommande $burgerCommande): self
    {
        if ($this->burgerCommandes->removeElement($burgerCommande)) {
            // set the owning side to null (unless already changed)
            if ($burgerCommande->getCommande() === $this) {
                $burgerCommande->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuCommande>
     */
    public function getMenuCommandes(): Collection
    {
        return $this->menuCommandes;
    }

    public function addMenuCommande(MenuCommande $menuCommande): self
    {
        if (!$this->menuCommandes->contains($menuCommande)) {
            $this->menuCommandes[] = $menuCommande;
            $menuCommande->setCommande($this);
        }

        return $this;
    }

    public function removeMenuCommande(MenuCommande $menuCommande): self
    {
        if ($this->menuCommandes->removeElement($menuCommande)) {
            // set the owning side to null (unless already changed)
            if ($menuCommande->getCommande() === $this) {
                $menuCommande->setCommande(null);
            }
        }

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
            $boissonCommande->setCommande($this);
        }

        return $this;
    }

    public function removeBoissonCommande(BoissonCommande $boissonCommande): self
    {
        if ($this->boissonCommandes->removeElement($boissonCommande)) {
            // set the owning side to null (unless already changed)
            if ($boissonCommande->getCommande() === $this) {
                $boissonCommande->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FriteCommande>
     */
    public function getFriteCommandes(): Collection
    {
        return $this->friteCommandes;
    }

    public function addFriteCommande(FriteCommande $friteCommande): self
    {
        if (!$this->friteCommandes->contains($friteCommande)) {
            $this->friteCommandes[] = $friteCommande;
            $friteCommande->setCommande($this);
        }

        return $this;
    }

    public function removeFriteCommande(FriteCommande $friteCommande): self
    {
        if ($this->friteCommandes->removeElement($friteCommande)) {
            // set the owning side to null (unless already changed)
            if ($friteCommande->getCommande() === $this) {
                $friteCommande->setCommande(null);
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
            $commandeMenuBoissonTaille->setCommandes($this);
        }

        return $this;
    }

    public function removeCommandeMenuBoissonTaille(CommandeMenuBoissonTaille $commandeMenuBoissonTaille): self
    {
        if ($this->commandeMenuBoissonTailles->removeElement($commandeMenuBoissonTaille)) {
            // set the owning side to null (unless already changed)
            if ($commandeMenuBoissonTaille->getCommandes() === $this) {
                $commandeMenuBoissonTaille->setCommandes(null);
            }
        }

        return $this;
    }

    // #[Assert\Callback]
    // public function validate(ExecutionContextInterface $context, $payload)
    // {
    //     $menus = count($this->getMenuCommandes());
    //     $burgers = count($this->getBurgerCommandes());
    //     if ($menus==0 && $burgers==0) {
    //         $context
    //             ->buildViolation("la commande ne doit pas seulement avoir des complements!")
    //             ->addViolation()
    //         ;
    //     }
 
    //     $menuCom = $this->getMenuCommandes();
    //     foreach ($menuCom as $menu) {
    //         foreach($menu->getMenu()->getCommandeMenuBoissonTailles() as $boissonTaille){
    //             $stock = $boissonTaille->getBoissonTailles()->getStock();
    //             $quantiteBoisson = $boissonTaille->getQuantite();
    //             if($stock==0 || $stock <0 || $quantiteBoisson > $stock){
    //                 $context
    //                 ->buildViolation("la quantite de boissons que vous avez demandé est indisponible")
    //                 ->addViolation()
    //                 ;
    //             }
    //         }
    //     }
        
    //     foreach ($menuCom as $menu) {
    //         foreach($menu->getMenu()->getMenuTailleBoissons() as $menuTaille){
    //            $idTaille = $menuTaille->getTailleBoisson()->getId();
    //            $quantiteBoisson = $menuTaille->getQuantite();
    //            $quantiteBoissonB = 0;
    //            foreach($menu->getMenu()->getCommandeMenuBoissonTailles() as $boissonTaille){
    //                 $idTailleB = $boissonTaille->getBoissonTailles()->getTailleBoisson()->getId();
    //                 if($idTaille == $idTailleB){
    //                     $quantiteBoissonB += $boissonTaille->getQuantite();
    //                 }   
    //                 $tab[] = $idTailleB;
    //             }
    //             if (!in_array($idTaille,$tab)){
    //                 $context
    //                     ->buildViolation("la taille de boisson que vous avez choisi ne se trouve pas dans le menu")
    //                     ->addViolation()
    //                     ;
    //             }
    //             if ($quantiteBoisson != $quantiteBoissonB) {
    //                 $context
    //                 ->buildViolation("la quantite de boisson que vous avez choisi ne se trouve pas dans le menu")
    //                 ->addViolation()
    //                 ;
    //             }
    //         }
    //     }
    // }
}
