<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\People;

use App\Actions\V1\People\DeletePersonAction;
use App\Models\Person;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

final class DeletePersonController
{
    /**
     * @param  Person  $person
     * @param  DeletePersonAction  $action
     * @return Response
     */
    public function __invoke(
        Person $person,
        DeletePersonAction $action
    ) {
        Gate::authorize('isAdminOrModerator');

        $action($person);

        return response()->noContent();
    }
}
