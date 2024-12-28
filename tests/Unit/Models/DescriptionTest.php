<?php

declare(strict_types=1);

use App\Models\Book;
use App\Models\Description;

it('description model to array', function () {
    $book = Book::factory()->create();

    /** @var Description $description */
    $description = Description::factory()
        ->create([
            'descriptionable_id' => $book->id,
            'descriptionable_type' => Book::class
        ])
        ->fresh();

    expect($description->toArray())->toHaveKeys([
        'id',
        'language',
        'text',
        'descriptionable_id',
        'descriptionable_type',
    ]);
});
