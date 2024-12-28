<?php

declare(strict_types=1);

namespace App\Http\Requests\Books;

use Illuminate\Foundation\Http\FormRequest;

final class StoreBookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'author_ids' => ['required', 'array', 'min:1', 'max:10'],
            'author_ids.*' => ['required', 'integer', 'exists:people,id'],
            'translator_ids' => ['nullable', 'array', 'min:1', 'max:10'],
            'translator_ids.*' => ['nullable', 'integer', 'exists:people,id'],
            'date_of_publication' => ['required', 'date'],
            'date_of_writing' => ['required', 'date'],
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
