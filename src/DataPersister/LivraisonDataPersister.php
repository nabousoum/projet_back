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
    public function persist($data,$context=[])
    {
        if(array_key_exists('item_operation_name',$context) && $context['item_operation_name'] == "put"){
          foreach ($context['previous_data']->getCommandes() as  $commande) {
            $commande->setEtat("paye");
          }
          $context['previous_data']->getLivreur()->setEtat("disponible");
        }
        if (array_key_exists('collection_operation_name',$context) && $context['collection_operation_name'] == "post_register"){
            $montantTotal = $this->montant->CalculMontant($data);
            $data->setMontantTotal($montantTotal);
            $data->getLivreur()->setEtat("indisponible");
        }
        $this->entityManager->persist($data);
        $this->entityManager->flush();
       
    }
    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
  

}
