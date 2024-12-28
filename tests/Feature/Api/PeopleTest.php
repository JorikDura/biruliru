<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Models\Name;
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
                        'names',
                        'descriptions',
                        'image'
                    ],

                ]
            ])
            ->assertSee([
                'id' => $person->id,
                'names' => $person->names,
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
                    'names',
                    'date_of_birth',
                    'date_of_death',
                    'descriptions',
                    'images'
                ]
            ])
            ->assertSee([
                'id' => $person->id,
                'names' => $person->names,
                'descriptions' => $person->descriptions
            ]);
    });

    it('add person', function () {
        /** @var Person $person */
        $person = Person::factory()->make();

        $name = Name::factory()->make([
            'nameable_id' => $person->id,
            'nameable_type' => Person::class
        ]);

        $test = postJson(
            uri: "api/v1/people",
            data: $person->toArray() + [
                'names' => [
                    [
                        'name' => $name->name,
                        'language' => $name->language
                    ]
                ],
            ]
        )->assertSuccessful()->assertJsonStructure([
            'data' => [
                'id',
                'names',
                'date_of_birth',
                'date_of_death',
                'descriptions',
                'images'
            ]
        ])->assertSee([
            'id' => $person->id,
            'names' => $person->names,
            'descriptions' => $person->descriptions
        ]);

        /** @var Person $person */
        $person = $test->original;

        assertDatabaseHas(
            table: 'people',
            data: [
                'id' => $person->id
            ]
        );
    });

    it('simple user trying to add person', function () {
        /** @var Person $person */
        $person = Person::factory()->make();

        $name = Name::factory()->make([
            'nameable_id' => $person->id,
            'nameable_type' => Person::class
        ]);

        Sanctum::actingAs($this->simpleUser);

        postJson(
            uri: "api/v1/people",
            data: $person->toArray() + [
                'names' => [
                    [
                        'name' => $name->name,
                        'language' => $name->language
                    ]
                ],
            ]
        )->assertForbidden();
    });

    it('edit person', function () {
        /** @var Person $person */
        $person = $this->people->random();

        postJson(uri: "api/v1/people/$person->id", data: [
            '_method' => 'PUT'
        ])->assertSuccessful()->assertJsonStructure([
            'data' => [
                'id',
                'names',
                'date_of_birth',
                'date_of_death',
                'descriptions',
                'images'
            ]
        ])->assertSee([
            'id' => $person->id,
            'names' => $person->names,
            'descriptions' => $person->descriptions
        ]);

        assertDatabaseHas(
            table: 'people',
            data: [
                'id' => $person->id
            ]
        );
    });

    it('simple user trying to edit person', function () {
        /** @var Person $person */
        $person = $this->people->random();

        Sanctum::actingAs($this->simpleUser);

        postJson(uri: "api/v1/people/$person->id", data: [
            '_method' => 'PUT'
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
