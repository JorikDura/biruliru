<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Book */
final class BookResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'names' => NameResource::collection($this->whenLoaded('names')),
            'date_of_publication' => $this->date_of_publication,
            'date_of_writing' => $this->date_of_writing,
            'descriptions' => DescriptionResource::collection($this->whenLoaded('descriptions')),
            'authors' => PersonResource::collection($this->whenLoaded('authors')),
            'translators' => PersonResource::collection($this->whenLoaded('translators')),
            'image' => ImageResource::make($this->whenLoaded('image')),
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'people' => PersonResource::collection($this->whenLoaded('people')),
        ];
    }
}
