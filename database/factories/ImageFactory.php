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
            'user_id' => $user = User::factory()->create()->id,
            'imageable_id' => $user,
            'imageable_type' => User::class,
            'original_path' => $this->faker->word(),
            'preview_path' => $this->faker->word()
        ];
    }
}
