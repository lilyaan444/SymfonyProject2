<?php

namespace App\Security\Voter;

use App\Entity\ClientEntity;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ClientVoter extends Voter
{
    public const VIEW = 'CLIENT_VIEW';
    public const EDIT = 'CLIENT_EDIT';
    public const DELETE = 'CLIENT_DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::VIEW, self::EDIT, self::DELETE])
            && ($subject instanceof ClientEntity || $subject === null);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        // Admin can do anything
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            return true;
        }

        // Manager can view and edit clients
        if (in_array('ROLE_MANAGER', $user->getRoles())) {
            return match ($attribute) {
                self::VIEW, self::EDIT => true,
                self::DELETE => false,
                default => false,
            };
        }

        return false;
    }
}