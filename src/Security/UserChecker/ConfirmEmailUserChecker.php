<?php

namespace App\Security\UserChecker;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ConfirmEmailUserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if ($user instanceof User && !$user->isEnabled()) {
            throw new CustomUserMessageAccountStatusException('Account is not enabled.');
        }
    }

    public function checkPostAuth(
        UserInterface $user,
        ?TokenInterface $token = null
    ): void {
        if (method_exists($user, 'isEnabled') && !$user->isEnabled()) {
            throw new CustomUserMessageAccountStatusException(
                'Vous devez confirmer votre email avant de vous connecter.'
            );
        }
    }
}
