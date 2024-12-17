<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Auth\Images;

use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\Response;

final class DeleteUserImageController
{
    /**
     * @param  User  $user
     * @return Response
     */
    public function __invoke(#[CurrentUser('sanctum')] User $user): Response
    {
        $user->deleteImage();

        return response()->noContent();
    }
}
