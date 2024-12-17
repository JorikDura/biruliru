<?php

declare(strict_types=1);

namespace App\Actions\V1\Books;

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
            $authors = $attributes['author_ids'] ?? null;
            $translators = $attributes['translator_ids'] ?? null;
            $images = $attributes['images'] ?? null;

            unset($attributes['images'], $attributes['translator_ids'], $attributes['author_ids']);

            $book->update($attributes);

            $book->people()->syncWithPivotValues($authors, [
                'role' => PersonRole::AUTHOR
            ]);

            $book->people()->syncWithPivotValues($translators, [
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
