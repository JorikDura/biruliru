<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\People;

use App\Actions\V1\People\UpdatePersonAction;
use App\Http\Requests\People\UpdatePersonRequest;
use App\Http\Resources\PersonResource;
use App\Models\Person;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Facades\Gate;

final class UpdatePersonController
{
    /**
     * @param  Person  $person
     * @param  UpdatePersonAction  $action
     * @param  UpdatePersonRequest  $request
     * @param  User  $user
     * @return PersonResource
     */
    public function __invoke(
        Person $person,
        UpdatePersonAction $action,
        UpdatePersonRequest $request,
        #[CurrentUser('sanctum')] User $user
    ): PersonResource {
        Gate::authorize('isAdminOrModerator');

        $person = $action($user, $person, $request->validated());

        return PersonResource::make($person);
    }
}
