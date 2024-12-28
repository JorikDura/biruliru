<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Description;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Description
 */
final class DescriptionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'language' => $this->language,
            'text' => $this->text
        ];
    }
}
