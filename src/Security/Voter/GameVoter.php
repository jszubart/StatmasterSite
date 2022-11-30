<?php

namespace App\Security\Voter;

use App\Entity\Game;
use App\Entity\Player;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class GameVoter extends Voter
{
    const EDIT = 'edit';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::EDIT])) {
            return false;
        }
        if (!$subject instanceof Game) {
            return false;
        }
        return true;
    }
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        if (!$user instanceof User) {
            return false;
        }
        /**
         * @var Player
         */
        $game = $subject;
        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($game, $user);
                break;
        }
        throw new \LogicException('This code should not be reached');
    }
    public function canEdit(Game $game, User $user)
    {
        if ($game->getUser() == null) {
            return false;
        } else
            return $game->getUser()->getId() == $user->getId();
    }
}
