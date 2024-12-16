<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Person extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'english_name',
        'russian_name',
        'original_name',
        'date_of_birth',
        'date_of_death',
        'description'
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'date_of_death' => 'date'
        ];
    }
}
