<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Description;
use Illuminate\Database\Eloquent\Factories\Factory;

final class DescriptionFactory extends Factory
{
    protected $model = Description::class;

    public function definition(): array
    {
        return [
            'language' => 'english',
            'text' => $this->faker->text(),
            'descriptionable_id' => $this->faker->uuid(),
            'descriptionable_type' => $this->faker->word(),
        ];
    }
}
