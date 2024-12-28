<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

final readonly class NameFilter implements Filter
{
    public function __invoke(Builder $query, mixed $value, string $property)
    {
        $query->whereHas('names', function (Builder $builder) use ($value) {
            $builder->whereRaw(
                sql: "vector_name @@ websearch_to_tsquery(?)",
                bindings: [$value]
            );
        });
    }
}
