<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PersonRole;
use App\Traits\HasDescriptions;
use App\Traits\HasImages;
use App\Traits\HasNames;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Book extends Model
{
    use HasDescriptions;
    use HasFactory;
    use HasImages;
    use HasNames;

    public $timestamps = false;

    protected $fillable = [
        'date_of_publication',
        'date_of_writing'
    ];

    /**
     * @return BelongsToMany
     */
    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class);
    }

    /**
     * @return BelongsToMany
     */
    public function authors(): BelongsToMany
    {
        return $this->people()->wherePivot('role', PersonRole::AUTHOR);
    }

    /**
     * @return BelongsToMany
     */
    public function translators(): BelongsToMany
    {
        return $this->people()->wherePivot('role', PersonRole::TRANSLATOR);
    }

    /**
     * @return ?bool
     */
    public function delete(): ?bool
    {
        $this->names()->delete();

        $this->descriptions()->delete();

        $this->deleteImages();

        return parent::delete();
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date_of_publication' => 'datetime',
            'date_of_writing' => 'datetime',
        ];
    }
}
