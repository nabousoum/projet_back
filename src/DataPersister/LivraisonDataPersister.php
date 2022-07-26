<?php
namespace App\DataPersister;

use DateTime;
use App\Entity\Burger;
use App\Service\Mailer;
use App\Entity\Livraison;
use App\Service\GenererNumCom;
use App\Entity\BurgerLivraison;
use App\Service\PasswordHasher;
use App\Service\MontantLivraison;
use App\Service\CalculMontantTotal;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;

class LivraisonDataPersister implements DataPersisterInterface
{

    private EntityManagerInterface $entityManager;
    public function __construct(
    EntityManagerInterface $entityManager,
    CalculMontantTotal $montant
    )
    {
        $this->entityManager = $entityManager;
        $this->montant = $montant;
    }
    public function supports($data): bool
    {
        return $data instanceof Livraison;
    }
    /**
    * @param Livraison $data
    */
    public function persist($data)
    {
     //dd($data->getCommandes()[0]->getMontantCommande());
        $montantTotal = $this->montant->CalculMontant($data);
        $data->setMontantTotal($montantTotal);
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
  

}
