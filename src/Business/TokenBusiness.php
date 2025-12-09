<?php

namespace App\Business;

use App\Entity\Token;
use App\Entity\User;

readonly class TokenBusiness
{

    public function generateTokenValue(int $size = 32): string
    {
        return bin2hex(random_bytes(floor($size / 2)));
    }

    public function createToken(User $user): Token
    {
        return (new Token())
            ->setUser($user)
            ->setValue($this->generateTokenValue())
            ->setExpiresAt(
                (new \DateTime())
                    ->add(new \DateInterval('PT15M'))
            );
    }
}
