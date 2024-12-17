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
            'english_name' => ['nullable', 'string', 'min:3', 'max:96'],
            'russian_name' => ['nullable', 'string', 'min:3', 'max:96'],
            'original_name' => ['nullable', 'string', 'min:3', 'max:96'],
            'date_of_publication' => ['nullable', 'date'],
            'date_of_writing' => ['nullable', 'date'],
            'english_description' => ['nullable', 'string', 'min:3', 'max:255'],
            'russian_description' => ['nullable', 'string', 'min:3', 'max:255'],
            'images' => ['nullable', 'array', 'min:1', 'max:8', new CounterRule($this->route('book'), 'images')],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif', 'max:24576'],
        ];
    }
}
