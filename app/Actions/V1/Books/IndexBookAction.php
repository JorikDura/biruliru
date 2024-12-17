<?php

declare(strict_types=1);

namespace App\Actions\V1\Books;

use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;

final readonly class IndexBookAction
{
    /**
     * Returns paginated list of books
     *
     * @return LengthAwarePaginator
     */
    public function __invoke(): LengthAwarePaginator
    {
        return Book::with(['image', 'authors'])
            ->paginate(columns: [
                'id',
                'english_name',
                'russian_name',
                'original_name',
                'date_of_publication',
                'date_of_writing'
            ])
            ->appends(request()->query());
    }
}
