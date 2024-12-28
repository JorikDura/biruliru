<?php

declare(strict_types=1);

namespace App\Http\Requests\People;

use Illuminate\Foundation\Http\FormRequest;

final class StorePersonRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date_of_birth' => ['nullable', 'date'],
            'date_of_death' => ['nullable', 'date'],
            'images' => ['nullable', 'array', 'min:1', 'max:8'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif', 'max:24576'],
            'names' => ['required', 'array', 'min:1', 'max:8'],
            'names.*name' => ['required', 'string', 'min:1', 'max:96'],
            'names.*language' => ['required', 'string', 'min:1', 'max:96'],
            'descriptions' => ['nullable', 'array', 'min:1', 'max:8'],
            'descriptions.*text' => ['required', 'string', 'min:1', 'max:255'],
            'descriptions.*language' => ['required', 'string', 'min:1', 'max:96'],
        ];
    }
}
