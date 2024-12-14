<?php

declare(strict_types=1);

namespace App\Actions\V1\Auth;

use App\Models\User;

final readonly class CreateTokenAction
{
    private const string TOKEN_NAME = 'access_token';

    /**
     * Generate a token for user.
     */
    public function __invoke(User $user): string
    {
        return $user->createToken(name: self::TOKEN_NAME)
            ->plainTextToken;
    }
}
