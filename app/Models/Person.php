<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasDescriptions;
use App\Traits\HasImages;
use App\Traits\HasNames;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Person extends Model
{
    use HasDescriptions;
    use HasFactory;
    use HasImages;
    use HasNames;

    public $timestamps = false;

    protected $fillable = [
        'date_of_birth',
        'date_of_death'
    ];

    /**
     * Deletes person model and it's images
     *
     * @return ?bool
     */
    public function delete(): ?bool
    {
        $this->names()->delete();

        $this->descriptions()->delete();

        $this->deleteImages();

        return parent::delete();
    }

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'date_of_death' => 'date'
        ];
    }
}
