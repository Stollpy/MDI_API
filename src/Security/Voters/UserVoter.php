<?php

namespace App\Security\Voters;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class UserVoter implements VoterInterface {

    public function vote(TokenInterface $token, $subject, array $attributes)
    {
        if(!$subject instanceof User){
            return self::ACCESS_ABSTAIN;
        }

        if(!in_array('USER_VOTER', $attributes)){
            return self::ACCESS_ABSTAIN;
        }

        $user = $token->getUser();

        if(!$user instanceof UserInterface){
            return self::ACCESS_DENIED;
        }

        if($subject !== $user){
            return self::ACCESS_DENIED;
        }

        return self::ACCESS_GRANTED;
    }
}