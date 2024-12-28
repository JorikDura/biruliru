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
            'names' => NameResource::collection($this->whenLoaded('names')),
            'date_of_birth' => $this->whenHas('date_of_birth'),
            'date_of_death' => $this->whenHas('date_of_death'),
            'descriptions' => DescriptionResource::collection($this->whenLoaded('descriptions')),
            'image' => ImageResource::make($this->whenLoaded('image')),
            'images' => ImageResource::collection($this->whenLoaded('images'))
        ];
    }
}
