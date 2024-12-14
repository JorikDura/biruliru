<?php

declare(strict_types=1);

namespace App\Actions\V1\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

final readonly class VerifyEmailAction
{
    /**
     * Verify user email
     */
    public function __invoke(User $user, array $attributes): void
    {
        abort_if(
            boolean: $user->hasVerifiedEmail(),
            code: Response::HTTP_BAD_REQUEST,
            message: 'You already verified your email address.'
        );

        /** @var int $userCode */
        $userCode = $attributes['code'];

        /** @var int $trueCode */
        $trueCode = Cache::get("email-$user->id");

        abort_if(
            boolean: $userCode !== $trueCode,
            code: Response::HTTP_BAD_REQUEST,
            message: 'Wrong verification code.'
        );

        $user->markEmailAsVerified();

        Cache::forget("email-$user->id");
    }
}
