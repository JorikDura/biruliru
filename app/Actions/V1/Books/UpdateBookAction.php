<?php

declare(strict_types=1);

namespace App\Actions\V1\Books;

use App\Actions\V1\Descriptions\DeleteDescriptionsAction;
use App\Actions\V1\Descriptions\UpdateDescriptionsAction;
use App\Actions\V1\Names\DeleteNamesAction;
use App\Actions\V1\Names\UpdateNamesAction;
use App\Enums\PersonRole;
use App\Models\Book;
use App\Models\Image;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final readonly class UpdateBookAction
{
    /**
     * Updates book model
     *
     * @param  Book  $book
     * @param  User|int  $user
     * @param  array  $attributes
     * @return Book
     */
    public function __invoke(Book $book, User|int $user, array $attributes): Book
    {
        return DB::transaction(static function () use ($book, $user, $attributes) {
            $attributes = fluent($attributes);

            $book->update($attributes->only([
                'date_of_publication',
                'date_of_writing'
            ]));

            $attributes->whenHas(
                key: 'names',
                callback: fn ($names) => app(UpdateNamesAction::class)->__invoke($book, $names)
            );

            $attributes->whenHas(
                key: 'descriptions',
                callback: fn ($descriptions) => app(UpdateDescriptionsAction::class)->__invoke($book, $descriptions)
            );

            $book->people()->syncWithPivotValues($attributes->get('author_ids'), [
                'role' => PersonRole::AUTHOR
            ]);

            $book->people()->syncWithPivotValues($attributes->get('translator_ids'), [
                'role' => PersonRole::TRANSLATOR
            ]);

            $attributes->whenHas(
                key: 'images',
                callback: fn ($images) => Image::insert(
                    files: $images,
                    model: $book,
                    user: $user
                )
            );

            $attributes->whenHas(
                key: 'delete_names_ids',
                callback: fn ($namesToDelete) => app(DeleteNamesAction::class)->__invoke($book, $namesToDelete)
            );

            $attributes->whenHas(
                key: 'delete_descriptions_ids',
                callback: fn ($descriptions) => app(DeleteDescriptionsAction::class)->__invoke($book, $descriptions)
            );

            return $book->load([
                'authors:id' => ['names'],
                'translators:id' => ['names'],
                'images',
                'names',
                'descriptions'
            ]);
        });
    }
}
