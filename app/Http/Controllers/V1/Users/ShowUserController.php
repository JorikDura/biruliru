<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Users;

use App\Http\Resources\UserResource;
use App\Models\User;

final class ShowUserController
{
    public function __invoke(User $user)
    {
        return UserResource::make($user);
    }
}
