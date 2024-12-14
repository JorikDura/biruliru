<?php

declare(strict_types=1);

namespace App\Actions\V1\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

final readonly class ResendCodeVerificationAction
{
    public function __invoke(User $user): void
    {
        abort_if(
            boolean: $user->hasVerifiedEmail(),
            code: Response::HTTP_BAD_REQUEST,
            message: 'You already verified your email address.'
        );

        Cache::forget("email-$user->id");

        $user->sendEmailVerificationNotification();
    }
}
