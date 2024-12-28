<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Name;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasNames
{
    public function names(): MorphMany
    {
        return $this->morphMany(Name::class, 'nameable');
    }
}
