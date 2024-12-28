<?php

declare(strict_types=1);

namespace App\Actions\V1\Books;

use App\Filters\NameFilter;
use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final readonly class IndexBookAction
{
    /**
     * Returns paginated list of books
     *
     * @return LengthAwarePaginator
     */
    public function __invoke(): LengthAwarePaginator
    {
        return QueryBuilder::for(Book::class)
            ->allowedFilters([
                AllowedFilter::custom('name', new NameFilter())
            ])
            ->with(['image', 'authors' => ['names'], 'names'])
            ->paginate(columns: [
                'id',
                'date_of_publication',
                'date_of_writing'
            ])
            ->appends(request()->query());
    }
}
