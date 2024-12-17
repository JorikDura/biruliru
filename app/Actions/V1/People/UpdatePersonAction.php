<?php

declare(strict_types=1);

namespace App\Actions\V1\People;

use App\Models\Image;
use App\Models\Person;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final readonly class UpdatePersonAction
{
    /**
     * Updates person
     *
     * @param  User|int  $user
     * @param  Person  $person
     * @param  array  $attributes
     * @return Person
     */
    public function __invoke(User|int $user, Person $person, array $attributes): Person
    {
        return DB::transaction(static function () use ($user, $person, $attributes) {
            $images = $attributes['images'] ?? null;

            unset($attributes['images']);

            $person->update($attributes);

            if (!is_null($images)) {
                Image::insert(
                    files: $images,
                    model: $person,
                    user: $user
                );
            }

            return $person;
        });
    }
}
