<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Person
 */
final class PersonResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'english_name' => $this->english_name,
            'russian_name' => $this->russian_name,
            'original_name' => $this->original_name,
            'date_of_birth' => $this->whenHas('date_of_birth'),
            'date_of_death' => $this->whenHas('date_of_death'),
            'english_description' => $this->whenHas('english_description'),
            'russian_description' => $this->whenHas('russian_description'),
            'image' => ImageResource::make($this->whenLoaded('image')),
            'images' => ImageResource::collection($this->whenLoaded('images'))
        ];
    }
}
