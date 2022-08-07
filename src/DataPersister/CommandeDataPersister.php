<?php
namespace App\DataPersister;

use DateTime;
use App\Service\Mailer;
use App\Entity\Commande;
use App\Service\GenererNumCom;
use App\Service\PasswordHasher;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Burger;
use App\Entity\BurgerCommande;
use App\Service\MontantCommande;

class CommandeDataPersister implements DataPersisterInterface
{

    private EntityManagerInterface $entityManager;
    public function __construct(
    EntityManagerInterface $entityManager,
    MontantCommande $montant,
    GenererNumCom $genererNum
    )
    {
        $this->entityManager = $entityManager;
        $this->genererNum = $genererNum;
        $this->montant = $montant;
    }
    public function supports($data): bool
    {
        return $data instanceof Commande;
    }
    /**
    * @param Commande $data
    */
    public function persist($data)
    {
        //dd( $data->getMenuCommandes()[0]->getMenu()->getCommandeMenuBoissonTailles()[2]);
        $menuCommandes = $data->getMenuCommandes();
        foreach ($menuCommandes as $menuCommande) {
            foreach ($menuCommande->getMenu()->getCommandeMenuBoissonTailles() as $commandemenutaille){
                $commandemenutaille->setCommandes($data);
            }
        }
        $data->setNumeroCommande($this->genererNum->genererCom());
        $montantCom = $this->montant->calculMontantCommande($data);
        $data->setMontantCommande($montantCom);
     
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
  

}
