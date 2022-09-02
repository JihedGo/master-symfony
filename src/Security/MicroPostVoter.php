<?php

namespace App\Security;

use App\Entity\MicroPost;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class MicroPostVoter extends Voter
{
    const EDIT = "edit";
    const DELETE =  "delete";
    private $decisionManager;
    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }
    protected function supports(string $attribute, $subject)
    {

        if (!in_array($attribute, [self::EDIT, self::DELETE])) {
            return false;
        }
        if (!$subject instanceof MicroPost) {
            return false;
        }
        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $authenticatedUser = $token->getUser();
        if ($this->decisionManager->decide($token, [User::ROLE_ADMIN])) {
            return true;
        }
        if (!$authenticatedUser instanceof User) {
            return false;
        }
        $microPost = $subject;
        $idUser = $authenticatedUser->getId();
        return ($microPost->getUser()->getId() === $authenticatedUser->getId());
        //return false;
    }
}