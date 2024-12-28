<?php

declare(strict_types=1);

namespace App\Actions\V1\People;

use App\Actions\V1\Descriptions\StoreDescriptionsAction;
use App\Actions\V1\Names\StoreNamesAction;
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
            $attributes = fluent($attributes);

            $person = Person::create($attributes->only([
                'date_of_birth',
                'date_of_death'
            ]));

            app(StoreNamesAction::class)->__invoke($person, $attributes->get('names'));

            $attributes->whenHas(
                key: 'descriptions',
                callback: fn ($descriptions) => app(StoreDescriptionsAction::class)->__invoke($person, $descriptions)
            );

            $attributes->whenHas(
                key: 'images',
                callback: fn ($images) => Image::insert(
                    files: $images,
                    model: $person,
                    user: $user
                )
            );

            return $person->load([
                'images',
                'names',
                'descriptions'
            ]);
        });
    }
}
