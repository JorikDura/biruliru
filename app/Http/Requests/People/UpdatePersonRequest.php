<?php

declare(strict_types=1);

namespace App\Http\Requests\People;

use App\Rules\CounterRule;
use Illuminate\Foundation\Http\FormRequest;

final class UpdatePersonRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date_of_birth' => ['nullable', 'date'],
            'date_of_death' => ['nullable', 'date'],
            'images' => ['nullable', 'array', 'min:1', 'max:8', new CounterRule($this->route('person'), 'images')],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif', 'max:24576'],
            'names' => ['nullable', 'array', 'min:1', 'max:8', new CounterRule($this->route('person'), 'names')],
            'names.*name' => ['required', 'string', 'min:1', 'max:96'],
            'names.*language' => ['required', 'string', 'min:1', 'max:96'],
            'descriptions' => [
                'nullable',
                'array',
                'min:1',
                'max:8',
                new CounterRule($this->route('person'), 'descriptions')
            ],
            'descriptions.*text' => ['required', 'string', 'min:1', 'max:255'],
            'descriptions.*language' => ['required', 'string', 'min:1', 'max:96'],
            'delete_names_ids' => ['nullable', 'array', 'min:1', 'max:8'],
            'delete_names_ids.*' => ['required', 'integer', 'exists:names,id'],
            'delete_descriptions_ids' => ['nullable', 'array', 'min:1', 'max:8'],
            'delete_descriptions_ids.*' => ['required', 'integer', 'exists:descriptions,id'],
        ];
    }
}
