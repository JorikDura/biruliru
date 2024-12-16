<?php

declare(strict_types=1);

namespace App\Actions\V1\People;

use App\Models\Person;
use Illuminate\Support\Facades\DB;

final class StorePersonAction
{
    /**
     * Creates Person
     *
     * @param  array  $attributes
     * @return Person
     */
    public function __invoke(array $attributes): Person
    {
        return DB::transaction(static function () use ($attributes) {
            return Person::create($attributes);
        });
    }
}
