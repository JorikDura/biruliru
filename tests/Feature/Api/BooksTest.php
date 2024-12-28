<?php

declare(strict_types=1);

use App\Enums\PersonRole;
use App\Enums\UserRole;
use App\Models\Book;
use App\Models\Description;
use App\Models\Image;
use App\Models\Name;
use App\Models\Person;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestHelpers;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

describe('books api endpoins', function () {
    beforeEach(function () {
        $this->userAdmin = User::factory()->create([
            'role' => UserRole::ADMIN
        ]);
        $this->books = Book::factory(15)
            ->has(Name::factory())
            ->has(Description::factory())
            ->create();

        /* $this->books->each(function (Book $book) {
             Name::factory()->create([
                 'nameable_id' => $book->id,
                 'nameable_type' => Book::class
             ]);
         });*/

        Person::factory()->create()->books()->attach($this->books, [
            'role' => PersonRole::AUTHOR
        ]);
        Sanctum::actingAs($this->userAdmin);
    });

    it('get books', function () {
        /** @var Book $book */
        $book = $this->books->random();

        getJson(uri: '/api/v1/books')
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'names',
                        'date_of_publication',
                        'date_of_writing',
                        'authors',
                        'image'
                    ]
                ]
            ])/*->assertSee([
                'id' => $book->id,
            ])*/
        ;
    });

    it('get book by id', function () {
        /** @var Book $book */
        $book = $this->books->random();

        /** @var Name $names */
        $name = $book->names()->first();

        /** @var Description $description */
        $description = $book->descriptions()->first();

        getJson(uri: "/api/v1/books/$book->id")
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'names',
                    'date_of_publication',
                    'date_of_writing',
                    'descriptions',
                    'authors',
                    'translators',
                    'images'
                ]
            ]);
        /*->assertSee([
            'id' => $book->id,
            'names' => [
                'id' => $name->id,
                'name' => $name->name,
                'language' => $name->language
            ],
            'descriptions' => [
                'id' => $description->id,
                'language' => $description->language,
                'text' => $description->text
            ]
        ]);*/
    });

    it('add book', function () {
        Storage::fake('public');

        $author = Person::factory()->create();

        /** @var Book $book */
        $book = Book::factory()->make();

        $name = Name::factory()->make([
            'nameable_id' => $book->id,
            'nameable_type' => Book::class
        ]);

        $test = postJson(
            uri: "/api/v1/books",
            data: $book->toArray() + [
                'names' => [
                    [
                        'name' => $name->name,
                        'language' => $name->language
                    ]
                ],
            ] + [
                'images' => TestHelpers::randomUploadedFiles(),
                'author_ids' => [$author->id],
            ]
        )->assertSuccessful()->assertJsonStructure([
            'data' => [
                'id',
                'names',
                'date_of_publication',
                'date_of_writing',
                'descriptions',
                'authors',
                'translators',
                'images'
            ]
        ])/*->assertSee([
            'english_name' => $book->english_name,
            'russian_name' => $book->russian_name,
            'original_name' => $book->original_name,
            'english_description' => $book->english_description,
            'russian_description' => $book->russian_description
        ])*/;

        assertDatabaseHas(
            table: 'books',
            data: $book->toArray()
        );

        /** @var Image $image */
        $image = $test->original->images->random();

        Storage::disk('public')->assertExists([
            $image->original_path,
            $image->preview_path
        ]);
    });

    it('update book', function () {
        Storage::fake('public');

        /** @var Book $book */
        $book = $this->books->random();

        $test = postJson(
            uri: "/api/v1/books/$book->id",
            data: [
                'images' => TestHelpers::randomUploadedFiles(),
                '_method' => 'PUT'
            ]
        )->assertSuccessful()->assertJsonStructure([
            'data' => [
                'id',
                'names',
                'date_of_publication',
                'date_of_writing',
                'descriptions',
                'authors',
                'translators',
                'images'
            ]
        ])/*->assertSee([
            'english_name' => $book->english_name,
            'russian_name' => $book->russian_name,
            'original_name' => $originalName,
            'english_description' => $book->english_description,
            'russian_description' => $book->russian_description
        ])*/;

        assertDatabaseHas(
            table: 'books',
            data: $book->toArray()
        );

        /** @var Image $image */
        $image = $test->original->images->random();

        Storage::disk('public')->assertExists([
            $image->original_path,
            $image->preview_path
        ]);
    });

    it('delete book', function () {
        /** @var Book $book */
        $book = $this->books->random();

        deleteJson(uri: "/api/v1/books/$book->id")
            ->assertSuccessful()
            ->assertNoContent();

        assertDatabaseMissing(
            table: 'books',
            data: $book->toArray()
        );
    });
});
