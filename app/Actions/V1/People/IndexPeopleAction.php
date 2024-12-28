<?php

declare(strict_types=1);

namespace App\Actions\V1\People;

use App\Filters\NameFilter;
use App\Models\Person;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final readonly class IndexPeopleAction
{
    /**
     * Returns paginated people list
     *
     * @return LengthAwarePaginator
     */
    public function __invoke(): LengthAwarePaginator
    {
        return QueryBuilder::for(Person::class)
            ->allowedFilters([
                AllowedFilter::custom('name', new NameFilter()),
            ])
            ->with(['image', 'names', 'descriptions'])
            ->paginate(columns: [
                'id'
            ])
            ->appends(request()->query());
    }
}
