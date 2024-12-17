<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Auth\Images;

use App\Actions\V1\Images\StoreImageAction;
use App\Http\Requests\Images\StoreImageRequest;
use App\Http\Resources\ImageResource;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use ReflectionException;

final class StoreUserImageController
{
    /**
     * @param  User  $user
     * @param  StoreImageAction  $action
     * @param  StoreImageRequest  $request
     * @return ImageResource
     * @throws ReflectionException
     */
    public function __invoke(
        StoreImageAction $action,
        StoreImageRequest $request,
        #[CurrentUser('sanctum')] User $user,
    ): ImageResource {
        $image = $action(
            user: $user,
            file: $request->validated('image')
        );

        return ImageResource::make($image);
    }
}
