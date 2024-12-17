<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

final class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'imageable_id' => $this->faker->uuid(),
            'imageable_type' => $this->faker->word(),
            'original_path' => $this->faker->word(),
            'preview_path' => $this->faker->word()
        ];
    }
}
