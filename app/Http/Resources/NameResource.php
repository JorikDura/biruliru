<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Name;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Name
 */
final class NameResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'language' => $this->language
        ];
    }
}
