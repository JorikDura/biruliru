<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Auth;

use App\Actions\V1\Auth\CreateTokenAction;
use App\Actions\V1\Auth\LoginAction;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\TokenResource;
use Symfony\Component\HttpFoundation\Response;

final class LoginController
{
    public function __invoke(
        LoginRequest $request,
        LoginAction $loginAction,
        CreateTokenAction $createTokenAction
    ) {
        $user = $loginAction($request->validated());

        if (is_null($user)) {
            return response()->json(
                data: [
                    'message' => 'These credentials do not match our records.',
                ],
                status: Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $token = $createTokenAction($user);

        return TokenResource::make($token);
    }
}
