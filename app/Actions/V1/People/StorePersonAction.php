<?php

declare(strict_types=1);

namespace App\Actions\V1\People;

use App\Models\Image;
use App\Models\Person;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final readonly class StorePersonAction
{
    /**
     * Creates Person
     *
     * @param  User|int  $user
     * @param  array  $attributes
     * @return Person
     */
    public function __invoke(User|int $user, array $attributes): Person
    {
        return DB::transaction(static function () use ($attributes, $user) {
            $images = $attributes['images'] ?? null;

            unset($attributes['images']);

            $person = Person::create($attributes);

            if (!is_null($images)) {
                Image::insert(
                    files: $images,
                    model: $person,
                    user: $user
                );
            }

            return $person->load(['images']);
        });
    }
}
