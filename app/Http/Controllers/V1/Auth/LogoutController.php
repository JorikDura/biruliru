<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Auth;

use App\Actions\V1\Auth\LogoutAction;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\Response;

final class LogoutController
{
    public function __construct(
        #[CurrentUser('sanctum')] private readonly User $user
    ) {
    }

    /**
     * @param  LogoutAction  $action
     * @return Response
     */
    public function __invoke(LogoutAction $action): Response
    {
        $action($this->user);

        return response()->noContent();
    }
}
