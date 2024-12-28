<?php

declare(strict_types=1);

namespace App\Actions\V1\Books;

use App\Actions\V1\Descriptions\StoreDescriptionsAction;
use App\Actions\V1\Names\StoreNamesAction;
use App\Enums\PersonRole;
use App\Models\Book;
use App\Models\Image;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final readonly class StoreBookAction
{
    /**
     * Stores book model
     *
     * @param  User  $user
     * @param  array  $attributes
     * @return Book
     */
    public function __invoke(User $user, array $attributes): Book
    {
        return DB::transaction(static function () use ($user, $attributes) {
            $attributes = fluent($attributes);

            $book = Book::create($attributes->only([
                'date_of_publication',
                'date_of_writing'
            ]));

            app(StoreNamesAction::class)->__invoke($book, $attributes->get('names'));

            $attributes->whenHas(
                key: 'descriptions',
                callback: fn ($descriptions) => app(StoreDescriptionsAction::class)->__invoke($book, $descriptions)
            );

            $book->people()->attach($attributes->get('author_ids'), [
                'role' => PersonRole::AUTHOR
            ]);

            $book->people()->attach($attributes->get('translator_ids'), [
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
