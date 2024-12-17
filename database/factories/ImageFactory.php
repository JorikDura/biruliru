<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

final class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition(): array
    {
        return [
            'imageable_id' => $this->faker->uuid(),
            'imageable_type' => $this->faker->word(),
            'original_path' => $this->faker->word(),
            'preview_path' => $this->faker->word()
        ];
    }
}
