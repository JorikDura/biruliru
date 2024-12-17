<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Books;

use App\Actions\V1\Books\UpdateBookAction;
use App\Http\Requests\Books\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Facades\Gate;

final class UpdateBookController
{
    /**
     * @param  Book  $book
     * @param  UpdateBookAction  $action
     * @param  UpdateBookRequest  $request
     * @param  User  $user
     * @return BookResource
     */
    public function __invoke(
        Book $book,
        UpdateBookAction $action,
        UpdateBookRequest $request,
        #[CurrentUser('sanctum')] User $user
    ): BookResource {
        Gate::authorize('isAdminOrModerator');

        $book = $action($book, $user, $request->validated());

        return BookResource::make($book);
    }
}
