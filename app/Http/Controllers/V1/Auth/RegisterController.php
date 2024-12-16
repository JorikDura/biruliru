<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Auth;

use App\Actions\V1\Auth\CreateTokenAction;
use App\Actions\V1\Auth\RegisterAction;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\TokenResource;

final class RegisterController
{
    /**
     * @param  RegisterRequest  $request
     * @param  RegisterAction  $registerAction
     * @param  CreateTokenAction  $createTokenAction
     * @return TokenResource
     */
    public function __invoke(
        RegisterRequest $request,
        RegisterAction $registerAction,
        CreateTokenAction $createTokenAction
    ): TokenResource {
        $user = $registerAction($request->validated());

        $token = $createTokenAction($user);

        return TokenResource::make($token);
    }
}
