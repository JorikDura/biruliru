<?php

declare(strict_types=1);

use App\Models\Image;

it('image model to array', function () {
    /** @var Image $image */
    $image = Image::factory()->create()->fresh();

    expect(array_keys($image->toArray()))->toEqual([
        'id',
        'user_id',
        'imageable_type',
        'imageable_id',
        'original_path',
        'preview_path'
    ]);
});
