<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\People;

use App\Models\Person;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

final class DeletePersonController
{
    /**
     * @param  Person  $person
     * @return Response
     */
    public function __invoke(Person $person)
    {
        Gate::authorize('isAdminOrModerator');

        $person->delete();

        return response()->noContent();
    }
}
