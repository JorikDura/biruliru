<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\People;

use App\Actions\V1\People\ShowPersonAction;
use App\Http\Resources\PersonResource;

final class ShowPersonController
{
    /**
     * @param  int  $personId
     * @param  ShowPersonAction  $action
     * @return PersonResource
     */
    public function __invoke(int $personId, ShowPersonAction $action): PersonResource
    {
        $person = $action($personId);

        return PersonResource::make($person);
    }
}
