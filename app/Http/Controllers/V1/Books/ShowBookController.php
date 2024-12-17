<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Books;

use App\Actions\V1\Books\ShowBookAction;
use App\Http\Resources\BookResource;

final class ShowBookController
{
    /**
     * @param  int  $bookId
     * @param  ShowBookAction  $action
     * @return BookResource
     */
    public function __invoke(
        int $bookId,
        ShowBookAction $action
    ): BookResource {
        $book = $action($bookId);

        return BookResource::make($book);
    }
}
