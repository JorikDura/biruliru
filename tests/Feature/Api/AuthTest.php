<?php

declare(strict_types=1);

use App\Models\User;
use App\Notifications\VerificationCodeNotification;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

describe('auth api endpoints', function () {
    it('register', function () {
        Notification::fake();

        postJson(
            uri: 'api/v1/auth/register',
            data: [
                'name' => $name = fake()->name,
                'email' => $email = fake()->unique()->email,
                'password' => $password = fake()->password(minLength: 8),
                'password_confirmation' => $password
            ]
        )->assertSuccessful()->assertJsonStructure([
            'data' => [
                'token'
            ]
        ]);

        assertDatabaseHas(
            table: 'users',
            data: [
                'name' => $name,
                'email' => $email
            ]
        );

        $user = User::whereEmail($email)->first();

        Notification::assertSentTo($user, VerificationCodeNotification::class);

        Notification::assertCount(1);
    });

    it('login', function () {
        /** @var User $user */
        $user = User::factory()->create([
            'password' => $password = fake()->password(minLength: 8)
        ]);

        postJson(
            uri: 'api/v1/auth/login',
            data: [
                'email' => $user->email,
                'password' => $password
            ]
        )->assertSuccessful()->assertJsonStructure([
            'data' => [
                'token'
            ]
        ]);
    });

    it('422 login (fake data)', function () {
        postJson(
            uri: 'api/v1/auth/login',
            data: [
                'email' => fake()->email,
                'password' => fake()->password(minLength: 8)
            ]
        )->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    });

    it('logout', function () {
        Sanctum::actingAs(User::factory()->create());

        postJson(uri: 'api/v1/auth/logout')
            ->assertSuccessful()
            ->assertNoContent();
    });

    it('resend verification code', function () {
        Notification::fake();

        Sanctum::actingAs(
            $user = User::factory()->create([
                'email_verified_at' => null
            ])
        );

        postJson(uri: 'api/v1/auth/email/verification/resend')
            ->assertSuccessful();

        Notification::assertSentTo($user, VerificationCodeNotification::class);

        Notification::assertCount(1);
    });
});
