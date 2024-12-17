<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Image;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasImages
{
    /**
     * Returns all images
     *
     * @return MorphMany
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Returns oldest image
     *
     * @return MorphOne
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable')->oldestOfMany();
    }

    /**
     * Deletes all images
     *
     * @return void
     */
    public function deleteImages(): void
    {
        /** @var Collection<array-key, Image> $images */
        $images = $this->images()->get();

        $images->each(function (Image $image) {
            $image->deleteImagesInStorage();
        });

        $this->images()->delete();
    }
}
