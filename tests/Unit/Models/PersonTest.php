<?php

declare(strict_types=1);

use App\Models\Person;

it('person model to array', function () {
    /** @var Person $person */
    $person = Person::factory()->create()->fresh();

    expect(array_keys($person->toArray()))->toEqual([
        'id',
        'english_name',
        'russian_name',
        'original_name',
        'date_of_birth',
        'date_of_death',
        'description'
    ]);
});
