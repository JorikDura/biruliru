<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Name;
use Illuminate\Database\Eloquent\Factories\Factory;

final class NameFactory extends Factory
{
    protected $model = Name::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'language' => 'english',
            'nameable_id' => $this->faker->uuid(),
            'nameable_type' => $this->faker->word(),
        ];
    }
}
