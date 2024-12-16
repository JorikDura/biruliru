<?php

declare(strict_types=1);

namespace App\Actions\V1\People;

use App\Models\Person;
use Illuminate\Support\Facades\DB;

final class DeletePersonAction
{
    /**
     * Deletes person
     *
     * @param  Person  $person
     * @return void
     */
    public function __invoke(Person $person): void
    {
        DB::transaction(function () use ($person) {
            $person->delete();
        });
    }
}
