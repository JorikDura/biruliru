<?php

declare(strict_types=1);

namespace App\Actions\V1\People;

use App\Actions\V1\Descriptions\DeleteDescriptionsAction;
use App\Actions\V1\Descriptions\UpdateDescriptionsAction;
use App\Actions\V1\Names\DeleteNamesAction;
use App\Actions\V1\Names\UpdateNamesAction;
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
            $attributes = fluent($attributes);

            $person->update($attributes->only([
                'date_of_birth',
                'date_of_death'
            ]));

            $attributes->whenHas(
                key: 'names',
                callback: fn ($names) => app(UpdateNamesAction::class)->__invoke($person, $names)
            );

            $attributes->whenHas(
                key: 'descriptions',
                callback: fn ($descriptions) => app(UpdateDescriptionsAction::class)->__invoke($person, $descriptions)
            );

            $attributes->whenHas(
                key: 'delete_names_ids',
                callback: fn ($namesToDelete) => app(DeleteNamesAction::class)->__invoke($person, $namesToDelete)
            );

            $attributes->whenHas(
                key: 'delete_descriptions_ids',
                callback: fn ($descriptions) => app(DeleteDescriptionsAction::class)->__invoke($person, $descriptions)
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
