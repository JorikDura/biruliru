<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class VerifyEmailRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => ['required', 'max:4'],
        ];
    }
}
