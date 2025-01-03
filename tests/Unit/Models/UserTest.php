<?php

declare(strict_types=1);

use App\Models\User;

it('user model to array', function () {
    /** @var User $user */
    $user = User::factory()->create()->fresh();

    expect(array_keys($user->toArray()))->toEqual([
        'id',
        'name',
        'email',
        'role',
        'gender',
        'email_verified_at',
        'custom_link',
        'created_at',
        'updated_at'
    ]);
});
