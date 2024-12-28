<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Description;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasDescriptions
{
    public function descriptions(): MorphMany
    {
        return $this->morphMany(Description::class, 'descriptionable');
    }
}
