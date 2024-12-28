<?php

declare(strict_types=1);

use App\Models\Person;

it('person model to array', function () {
    /** @var Person $person */
    $person = Person::factory()->create()->fresh();

    expect($person->toArray())->toHaveKeys([
        'id',
        'date_of_birth',
        'date_of_death'
    ]);
});
