<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class PersonFactory extends Factory
{
    protected $model = Person::class;

    public function definition(): array
    {
        return [
            'english_name' => fake()->name,
            'russian_name' => fake()->name,
            'original_name' => fake()->name,
            'date_of_birth' => Carbon::now(),
            'date_of_death' => Carbon::now(),
            'english_description' => fake()->text(),
            'russian_description' => fake()->text()
        ];
    }
}
