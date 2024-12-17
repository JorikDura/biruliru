<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition(): array
    {
        return [
            'original_path' => $this->faker->word(),
            'preview_path' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
