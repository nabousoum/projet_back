<?php
// api/src/Security/Voter/LivraisonVoter.php

namespace App\Security\Voter;

use App\Entity\Livraison;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class LivraisonVoter extends Voter
{
    private $security = null;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject): bool
    {
        if ($attribute == "LIVRAISON_ALL") {
            $subject = new $subject();
        }
        $supportsAttribute = in_array($attribute, ['LIVRAISON_CREATE', 'LIVRAISON_READ', 'LIVRAISON_EDIT', 'LIVRAISON_DELETE','LIVRAISON_ALL']);
        $supportsSubject = $subject instanceof Livraison;
        return $supportsAttribute && $supportsSubject;
   
    }

    /**
     * @param string $attribute
     * @param Livraison $subject
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
            case 'LIVRAISON_CREATE':
                if ( $this->security->isGranted("ROLE_GESTIONNAIRE") ) 
                { 
                    return true;
                }  // only admins can create Livraisons
                break;
            case 'LIVRAISON_ALL':
                if ( $this->security->isGranted("ROLE_GESTIONNAIRE") ) 
                { 
                    return true;
                }  // only admins can create Livraisons
                break;
            case 'LIVRAISON_READ':
                if ( $this->security->isGranted("ROLE_GESTIONNAIRE") ) 
                { 
                    return true;
                } 
                break;
            case 'LIVRAISON_EDIT':
                if ( $this->security->isGranted("ROLE_GESTIONNAIRE") ) 
                { 
                    return true;
                } 
                break;
        }

        return false;
    }
}