<?php

declare(strict_types=1);

namespace App\Http\Requests\People;

use Illuminate\Foundation\Http\FormRequest;

final class UpdatePersonRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'english_name' => ['nullable', 'string', 'min:3', 'max:100'],
            'russian_name' => ['nullable', 'string', 'min:3', 'max:100'],
            'original_name' => ['nullable', 'string', 'min:3', 'max:100'],
            'date_of_birth' => ['nullable', 'date'],
            'date_of_death' => ['nullable', 'date'],
            'description' => ['nullable', 'string', 'min:3', 'max:255'],
        ];
    }
}
