<?php

declare(strict_types=1);

use App\Models\Book;

it('book model to array', function () {
    /** @var Book $book */
    $book = Book::factory()->create()->fresh();

    expect($book->toArray())->toHaveKeys([
        'id',
        'date_of_publication',
        'date_of_writing'
    ]);
});
