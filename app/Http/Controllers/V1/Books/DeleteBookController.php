<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Books;

use App\Models\Book;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

final class DeleteBookController
{
    /**
     * @param  Book  $book
     * @return Response
     */
    public function __invoke(Book $book): Response
    {
        Gate::authorize('isAdminOrModerator');

        $book->delete();

        return response()->noContent();
    }
}
