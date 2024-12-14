<?php

declare(strict_types=1);

use App\Models\User;

use function Pest\Laravel\getJson;

describe('user api endpoints', function () {
    beforeEach(function () {
        $this->users = User::factory(5)->create();
    });

    it('get users', function () {
        /** @var User $user */
        $user = $this->users->random();

        getJson(uri: 'api/v1/users')
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'name'
                    ]
                ]
            ])
            ->assertSee([
                'id' => $user->id,
                'name' => $user->name
            ]);
    });

    it('get user by link', function () {
        /** @var User $user */
        $user = $this->users->random();

        getJson(uri: "api/v1/users/$user->custom_link")
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name'
                ]
            ])
            ->assertSee([
                'id' => $user->id,
                'name' => $user->name
            ]);
    });

    it('get user by id', function () {
        /** @var User $user */
        $user = $this->users->random();

        getJson(uri: "api/v1/users/$user->id")
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name'
                ]
            ])
            ->assertSee([
                'id' => $user->id,
                'name' => $user->name
            ]);
    });

    it('get user by numeric custom link', function () {
        /** @var User $user */
        $user = User::factory()->create([
            'custom_link' => $number = fake()->numberBetween(432, 956)
        ]);

        getJson(uri: "api/v1/users/$number")
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name'
                ]
            ])
            ->assertSee([
                'id' => $user->id,
                'name' => $user->name
            ]);
    });
});
