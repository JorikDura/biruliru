<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Models\Person;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

describe('people api endpoints', function () {
    beforeEach(function () {
        $this->user = User::factory()->create(['role' => UserRole::ADMIN]);
        $this->people = Person::factory(15)->create();
        Sanctum::actingAs($this->user);

        $this->simpleUser = User::factory()->create();
    });

    it('get people', function () {
        /** @var Person $person */
        $person = $this->people->random();

        getJson(uri: 'api/v1/people')
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'russian_name',
                        'english_name',
                        'original_name'
                    ],

                ]
            ])
            ->assertSee([
                'id' => $person->id,
                'russian_name' => $person->russian_name,
                'english_name' => $person->english_name,
                'original_name' => $person->original_name
            ]);
    });

    it('get person by id', function () {
        /** @var Person $person */
        $person = $this->people->random();

        getJson(uri: "api/v1/people/$person->id")
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'russian_name',
                    'english_name',
                    'original_name',
                    'date_of_birth',
                    'date_of_death',
                    'description'
                ]
            ])
            ->assertSee([
                'id' => $person->id,
                'russian_name' => $person->russian_name,
                'english_name' => $person->english_name,
                'original_name' => $person->original_name,
                'description' => $person->description
            ]);
    });

    it('add person', function () {
        /** @var Person $person */
        $person = Person::factory()->make();

        postJson(uri: "api/v1/people", data: $person->toArray())
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'russian_name',
                    'english_name',
                    'original_name',
                    'date_of_birth',
                    'date_of_death',
                    'description'
                ]
            ])
            ->assertSee([
                'id' => $person->id,
                'russian_name' => $person->russian_name,
                'english_name' => $person->english_name,
                'original_name' => $person->original_name,
                'description' => $person->description
            ]);

        assertDatabaseHas(
            table: 'people',
            data: [
                'russian_name' => $person->russian_name,
                'english_name' => $person->english_name,
                'original_name' => $person->original_name,
                'description' => $person->description
            ]
        );
    });

    it('simple user trying to add person', function () {
        /** @var Person $person */
        $person = Person::factory()->make();

        Sanctum::actingAs($this->simpleUser);

        postJson(uri: "api/v1/people", data: $person->toArray())
            ->assertForbidden();
    });

    it('edit person', function () {
        /** @var Person $person */
        $person = $this->people->random();

        postJson(uri: "api/v1/people/$person->id", data: [
            '_method' => 'PUT',
            'english_name' => $englishName = fake()->name(),
        ])->assertSuccessful()->assertJsonStructure([
            'data' => [
                'id',
                'russian_name',
                'english_name',
                'original_name',
                'date_of_birth',
                'date_of_death',
                'description'
            ]
        ])->assertSee([
            'id' => $person->id,
            'russian_name' => $person->russian_name,
            'english_name' => $englishName,
            'original_name' => $person->original_name,
            'description' => $person->description
        ]);

        assertDatabaseHas(
            table: 'people',
            data: [
                'id' => $person->id,
                'russian_name' => $person->russian_name,
                'english_name' => $englishName,
                'original_name' => $person->original_name,
                'description' => $person->description
            ]
        );
    });

    it('simple user trying to edit person', function () {
        /** @var Person $person */
        $person = $this->people->random();

        Sanctum::actingAs($this->simpleUser);

        postJson(uri: "api/v1/people/$person->id", data: [
            '_method' => 'PUT',
            'english_name' => fake()->name(),
        ])->assertForbidden();
    });

    it('delete person', function () {
        /** @var Person $person */
        $person = $this->people->random();

        deleteJson(uri: "api/v1/people/$person->id")
            ->assertSuccessful()
            ->assertNoContent();

        assertDatabaseMissing(
            table: 'people',
            data: $person->toArray()
        );
    });

    it('simple user trying to delete person', function () {
        /** @var Person $person */
        $person = $this->people->random();

        Sanctum::actingAs($this->simpleUser);

        deleteJson(uri: "api/v1/people/$person->id")
            ->assertForbidden();
    });
});
