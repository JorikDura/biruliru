<?php

declare(strict_types=1);

namespace App\Actions\V1\Books;

use App\Models\Book;

final readonly class ShowBookAction
{
    /**
     * Return book model via id
     *
     * @param  int  $bookId
     * @return Book
     */
    public function __invoke(int $bookId): Book
    {
        return Book::with([
            'images',
            'authors' => ['names'],
            'translators' => ['names'],
            'names',
            'descriptions'
        ])->select(
            [
                'id',
                'date_of_publication',
                'date_of_writing'
            ]
        )->findOrFail($bookId);
    }
}
