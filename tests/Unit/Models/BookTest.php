<?php

declare(strict_types=1);

use App\Models\Book;

it('book model to array', function () {
    /** @var Book $book */
    $book = Book::factory()->create()->fresh();

    expect(array_keys($book->toArray()))->toEqual([
        'id',
        'english_name',
        'russian_name',
        'original_name',
        'date_of_publication',
        'date_of_writing',
        'english_description',
        'russian_description'
    ]);
});
