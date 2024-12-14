<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Auth;

use App\Actions\V1\Auth\ResendCodeVerificationAction;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\Response;

final class ResendCodeVerificationController
{
    public function __construct(
        #[CurrentUser('sanctum')] private readonly User $user
    ) {
    }

    /**
     * Resends code for email verification
     */
    public function __invoke(ResendCodeVerificationAction $action): Response
    {
        $action($this->user);

        return response()->noContent();
    }
}
