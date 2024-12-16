<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\People;

use App\Actions\V1\People\StorePersonAction;
use App\Http\Requests\People\StorePersonRequest;
use App\Http\Resources\PersonResource;
use Illuminate\Support\Facades\Gate;

final class StorePersonController
{
    /**
     * @param  StorePersonAction  $action
     * @param  StorePersonRequest  $request
     * @return PersonResource
     */
    public function __invoke(
        StorePersonAction $action,
        StorePersonRequest $request
    ): PersonResource {
        Gate::authorize('isAdminOrModerator');

        $person = $action($request->validated());

        return PersonResource::make($person);
    }
}
