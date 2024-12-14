<?php

declare(strict_types=1);

namespace App\Actions\V1\Auth;

use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

final class LogoutAction
{
    public function __invoke(User $user): void
    {
        /** @var PersonalAccessToken $currentToken */
        $currentToken = $user->currentAccessToken();

        $currentToken->delete();
    }
}