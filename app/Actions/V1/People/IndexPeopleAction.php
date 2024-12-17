<?php

declare(strict_types=1);

namespace App\Actions\V1\People;

use App\Models\Person;
use Illuminate\Pagination\LengthAwarePaginator;

final readonly class IndexPeopleAction
{
    /**
     * Returns paginated people list
     *
     * @return LengthAwarePaginator
     */
    public function __invoke(): LengthAwarePaginator
    {
        return Person::with([
            'image'
        ])->paginate(columns: [
            'id',
            'english_name',
            'russian_name',
            'original_name'
        ])->appends(request()->query());
    }
}
