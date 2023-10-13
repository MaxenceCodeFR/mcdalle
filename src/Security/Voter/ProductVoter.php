<?php

namespace App\Security\Voter;


use App\Entity\Products;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ProductVoter extends Voter
{
    const EDIT = 'edit';
    const DELETE = 'delete';

    public function __construct(private Security $security)
    {
    }



    protected function supports(string $attribute, $product): bool
    {
        if (!in_array($attribute, [self::EDIT, self::DELETE])) {
            return false;
        }
        if (!$product instanceof Products) {
            return false;
        }
        return true;

        //Syntaxe alternative
        //return in_array($attribute, [self::EDIT, self::DELETE]) && $product instanceof Products;
    }

    protected function voteOnAttribute($attribute, $product, TokenInterface $token): bool
    {
        //On récupère l'utilisateur connecté
        $user = $token->getUser();

        //On vérifie que l'utilisateur existe
        if (!$user instanceof UserInterface) return false;

        //On verifie que l'utilisateur est admin
        if ($this->security->isGranted('ROLE_ADMIN')) return true;

        //On vérifie les permissions
        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit();
            case self::DELETE:
                return $this->canDelete();
        }
    }

    private function canEdit()
    {
        return $this->security->isGranted('ROLE_PRODUCT_ADMIN') || $this->security->isGranted('ROLE_ADMIN');
    }

    private function canDelete()
    {
        return $this->security->isGranted('ROLE_ADMIN') || $this->security->isGranted('ROLE_SUPER_ADMIN');
    }
}
