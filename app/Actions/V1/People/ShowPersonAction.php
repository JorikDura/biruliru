<?php

declare(strict_types=1);

namespace App\Actions\V1\People;

use App\Models\Person;

final readonly class ShowPersonAction
{
    /**
     * Shows person by id
     *
     * @param  int  $personId
     * @return Person
     */
    public function __invoke(int $personId): Person
    {
        return Person::with([
            'images'
        ])->select([
            'id',
            'english_name',
            'russian_name',
            'original_name',
            'date_of_birth',
            'date_of_death',
            'description',
        ])->findOrFail($personId);
    }
}
