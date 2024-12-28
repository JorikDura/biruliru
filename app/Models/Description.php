<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

final class Description extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'language',
        'text',
        'descriptionable_id',
        'descriptionable_type',
    ];

    public function description(): MorphTo
    {
        return $this->morphTo();
    }
}
