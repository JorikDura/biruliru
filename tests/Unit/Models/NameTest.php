<?php

declare(strict_types=1);

use App\Models\Book;
use App\Models\Name;

it('name model to array', function () {
    $book = Book::factory()->create();
    /** @var Name $name */

    $name = Name::factory()
        ->create([
            'nameable_id' => $book->id,
            'nameable_type' => Book::class
        ])
        ->fresh();

    expect($name->toArray())->toHaveKeys([
        'id',
        'name',
        'nameable_id',
        'nameable_type',
        'language'
    ]);
});
