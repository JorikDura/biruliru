<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Books;

use App\Actions\V1\Books\IndexBookAction;
use App\Http\Resources\BookResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class IndexBookController
{
    /**
     * @param  IndexBookAction  $action
     * @return AnonymousResourceCollection
     */
    public function __invoke(IndexBookAction $action): AnonymousResourceCollection
    {
        $books = $action();

        return BookResource::collection($books);
    }
}
