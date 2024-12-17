<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Person extends Model
{
    use HasFactory;
    use HasImages;

    public $timestamps = false;
    protected $fillable = [
        'english_name',
        'russian_name',
        'original_name',
        'date_of_birth',
        'date_of_death',
        'description'
    ];

    /**
     * Deletes person model and it's images
     *
     * @return ?bool
     */
    public function delete(): ?bool
    {
        $this->deleteImages();

        return parent::delete();
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
