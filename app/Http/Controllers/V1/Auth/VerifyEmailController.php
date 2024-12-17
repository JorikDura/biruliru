<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Auth;

use App\Actions\V1\Auth\VerifyEmailAction;
use App\Http\Requests\Auth\VerifyEmailRequest;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\Response;

final class VerifyEmailController
{
    public function __construct(
        #[CurrentUser('sanctum')] private readonly User $user
    ) {
    }

    /**
     * @param  VerifyEmailRequest  $request
     * @param  VerifyEmailAction  $action
     * @return Response
     */
    public function __invoke(
        VerifyEmailRequest $request,
        VerifyEmailAction $action
    ): Response {
        $action($this->user, $request->validated());

        return response()->noContent();
    }
}
