<?php

declare(strict_types=1);

namespace App\Http\Requests\Images;

use Illuminate\Foundation\Http\FormRequest;

final class StoreImageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => ['required', 'image', 'mimes:jpeg,jpg,png,gif', 'max:24576'],
        ];
    }
}
