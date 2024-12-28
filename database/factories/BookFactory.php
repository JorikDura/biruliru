<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'date_of_publication' => Carbon::now(),
            'date_of_writing' => Carbon::now()
        ];
    }
}
