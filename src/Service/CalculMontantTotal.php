<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class CalculMontantTotal
{
   

    public function CalculMontant($data){
      $montantTotal = 0;
      $commandes = $data->getCommandes(); 
      foreach ($commandes as $commande) {
        $montantTotal += $commande->getMontantCommande();
      }
      return $montantTotal;
    }
    
}