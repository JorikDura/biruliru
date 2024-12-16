<?php

declare(strict_types=1);

namespace App\Actions\V1\People;

use App\Models\Person;
use Illuminate\Support\Facades\DB;

final class UpdatePersonAction
{
    /**
     * Updates person
     *
     * @param  Person  $person
     * @param  array  $attributes
     * @return Person
     */
    public function __invoke(Person $person, array $attributes): Person
    {
        return DB::transaction(static function () use ($person, $attributes) {
            $person->update($attributes);

            return $person;
        });
    }
}
