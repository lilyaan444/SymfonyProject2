<?php

namespace App\Security\Voter;

use App\Entity\UserEntity;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{
    public const EDIT = 'USER_EDIT';
    public const DELETE = 'USER_DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof UserEntity;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        /** @var UserEntity $userEntity */
        $userEntity = $subject;

        return match($attribute) {
            self::EDIT => $this->canEdit($userEntity, $user),
            self::DELETE => $this->canDelete($userEntity, $user),
            default => false,
        };
    }

    private function canEdit(UserEntity $userEntity, UserInterface $user): bool
    {
        // Only admin can edit users
        return in_array('ROLE_ADMIN', $user->getRoles());
    }

    private function canDelete(UserEntity $userEntity, UserInterface $user): bool
    {
        // Only admin can delete users, and they can't delete themselves
        return in_array('ROLE_ADMIN', $user->getRoles()) && $user !== $userEntity;
    }
}