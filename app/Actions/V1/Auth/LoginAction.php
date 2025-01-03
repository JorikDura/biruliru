<?php

declare(strict_types=1);

namespace App\Actions\V1\Auth;

use App\Models\User;

final readonly class LoginAction
{
    /**
     * Logins user
     *
     * @param  array  $attributes
     * @return ?User
     */
    public function __invoke(array $attributes): ?User
    {
        auth()->attempt($attributes);

        return auth()->user();
    }
}
