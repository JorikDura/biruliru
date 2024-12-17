<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Image
 */
final class ImageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => $this->whenLoaded('user'),
            $this->mergeWhen(! $this->relationLoaded('user'), [
                'user_id' => $this->user_id,
            ]),
            'original_image_url' => asset("storage/$this->original_path"),
            'preview_image_url' => ! is_null($this->preview_path)
                ? asset("storage/$this->preview_path")
                : asset("storage/$this->original_path"),
        ];
    }
}
