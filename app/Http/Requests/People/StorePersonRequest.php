<?php

declare(strict_types=1);

namespace App\Http\Requests\People;

use Illuminate\Foundation\Http\FormRequest;

final class StorePersonRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'english_name' => ['required', 'string', 'min:3', 'max:100'],
            'russian_name' => ['required', 'string', 'min:3', 'max:100'],
            'original_name' => ['required', 'string', 'min:3', 'max:100'],
            'date_of_birth' => ['nullable', 'date'],
            'date_of_death' => ['nullable', 'date'],
            'english_description' => ['nullable', 'string', 'min:3', 'max:255'],
            'russian_description' => ['nullable', 'string', 'min:3', 'max:255'],
            'images' => ['nullable', 'array', 'min:1', 'max:8'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif', 'max:24576'],
        ];
    }
}
