<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\People;

use App\Actions\V1\People\StorePersonAction;
use App\Http\Requests\People\StorePersonRequest;
use App\Http\Resources\PersonResource;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Facades\Gate;

final class StorePersonController
{
    /**
     * @param  StorePersonAction  $action
     * @param  StorePersonRequest  $request
     * @param  User  $user
     * @return PersonResource
     */
    public function __invoke(
        StorePersonAction $action,
        StorePersonRequest $request,
        #[CurrentUser('sanctum')] User $user
    ): PersonResource {
        Gate::authorize('isAdminOrModerator');

        $person = $action($user, $request->validated());

        return PersonResource::make($person);
    }
}
