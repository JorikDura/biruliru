<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Users;

use App\Actions\V1\Users\IndexUserAction;
use App\Http\Resources\UserResource;

final class IndexUserController
{
    public function __invoke(IndexUserAction $action)
    {
        $users = $action();

        return UserResource::collection($users);
    }
}
