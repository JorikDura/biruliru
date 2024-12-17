<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Users;

use App\Actions\V1\Users\IndexUserAction;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class IndexUserController
{
    /**
     * @param  IndexUserAction  $action
     * @return AnonymousResourceCollection
     */
    public function __invoke(IndexUserAction $action): AnonymousResourceCollection
    {
        $users = $action();

        return UserResource::collection($users);
    }
}
