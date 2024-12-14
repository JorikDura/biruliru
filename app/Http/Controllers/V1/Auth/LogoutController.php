<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Auth;

use App\Actions\V1\Auth\LogoutAction;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;

final class LogoutController
{
    public function __construct(
        #[CurrentUser('sanctum')] private readonly User $user
    ) {
    }

    public function __invoke(LogoutAction $action)
    {
        $action($this->user);

        return response()->noContent();
    }
}
