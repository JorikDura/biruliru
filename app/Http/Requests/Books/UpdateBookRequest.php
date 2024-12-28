<?php

declare(strict_types=1);

namespace App\Http\Requests\Books;

use App\Rules\CounterRule;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateBookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'author_ids' => ['nullable', 'array', 'min:1', 'max:10'],
            'author_ids.*' => ['nullable', 'integer', 'exists:people,id'],
            'translator_ids' => ['nullable', 'array', 'min:1', 'max:10'],
            'translator_ids.*' => ['nullable', 'integer', 'exists:people,id'],
            'date_of_publication' => ['nullable', 'date'],
            'date_of_writing' => ['nullable', 'date'],
            'images' => ['nullable', 'array', 'min:1', 'max:8', new CounterRule($this->route('book'), 'images')],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif', 'max:24576'],
            'names' => ['nullable', 'array', 'min:1', 'max:8', new CounterRule($this->route('book'), 'names')],
            'names.*id' => ['nullable', 'integer', 'exists:names,id'],
            'names.*name' => ['required', 'string', 'min:1', 'max:96'],
            'names.*language' => ['required', 'string', 'min:1', 'max:96'],
            'descriptions' => [
                'nullable',
                'array',
                'min:1',
                'max:8',
                new CounterRule($this->route('book'), 'descriptions')
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
