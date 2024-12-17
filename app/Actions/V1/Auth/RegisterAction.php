<?php

declare(strict_types=1);

namespace App\Actions\V1\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;

final readonly class RegisterAction
{
    /**
     * Registers user
     *
     * @param  array  $attributes
     * @return User
     */
    public function __invoke(array $attributes): User
    {
        $user = User::create($attributes);

        event(new Registered($user));

        return $user;
    }
}
