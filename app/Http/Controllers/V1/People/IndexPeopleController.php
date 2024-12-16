<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\People;

use App\Actions\V1\People\IndexPeopleAction;
use App\Http\Resources\PersonResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class IndexPeopleController
{
    /**
     * @param  IndexPeopleAction  $action
     * @return AnonymousResourceCollection
     */
    public function __invoke(IndexPeopleAction $action): AnonymousResourceCollection
    {
        $people = $action();

        return PersonResource::collection($people);
    }
}
