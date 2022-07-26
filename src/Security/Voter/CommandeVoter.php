<?php
// api/src/Security/Voter/CommandeVoter.php

namespace App\Security\Voter;

use App\Entity\Commande;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class CommandeVoter extends Voter
{
    private $security = null;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject): bool
    {
        if ($attribute == "COMMANDE_ALL") {
            $subject = new $subject();
        }
        $supportsAttribute = in_array($attribute, ['COMMANDE_CREATE', 'COMMANDE_READ', 'COMMANDE_EDIT', 'COMMANDE_DELETE','COMMANDE_ALL']);
        $supportsSubject = $subject instanceof Commande;
        return $supportsAttribute && $supportsSubject;
   
    }

    /**
     * @param string $attribute
     * @param Commande $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        switch ($attribute) {
            case 'COMMANDE_CREATE':
                if ( $this->security->isGranted("ROLE_CLIENT") ) 
                { 
                    return true;
                }  // only admins can create Commandes
                break;
            case 'COMMANDE_ALL':
                if ( $this->security->isGranted("ROLE_GESTIONNAIRE") ) 
                { 
                    return true;
                }  // only admins can create Commandes
                break;
            case 'COMMANDE_READ':
                if ( $this->security->isGranted("ROLE_CLIENT") ) 
                { 
                    return true;
                } 
                break;
            case 'COMMANDE_EDIT':
                if ( $this->security->isGranted("ROLE_GESTIONNAIRE") ) 
                { 
                    return true;
                } 
                break;
        }

        return false;
    }
}