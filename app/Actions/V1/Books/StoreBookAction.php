<?php

declare(strict_types=1);

namespace App\Actions\V1\Books;

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
            $authors = $attributes['author_ids'];
            $translators = $attributes['translator_ids'] ?? null;
            $images = $attributes['images'] ?? null;

            unset($attributes['images'], $attributes['translator_ids'], $attributes['author_ids']);

            $book = Book::create($attributes);

            $book->people()->attach($authors, [
                'role' => PersonRole::AUTHOR
            ]);

            $book->people()->attach($translators, [
                'role' => PersonRole::TRANSLATOR
            ]);

            if (!is_null($images)) {
                Image::insert(
                    files: $images,
                    model: $book,
                    user: $user
                );
            }

            return $book->load([
                'authors:id,english_name,russian_name,original_name',
                'translators:id,english_name,russian_name,original_name',
                'images'
            ]);
        });
    }
}
