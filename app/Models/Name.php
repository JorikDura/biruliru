<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property string $language
 */
final class Name extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'nameable_id',
        'nameable_type',
        'language',
        'vector_name'
    ];

    protected $hidden = [
        'vector_name'
    ];

    public function name(): MorphTo
    {
        return $this->morphTo();
    }
}
