<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Books;

use App\Actions\V1\Books\StoreBookAction;
use App\Http\Requests\Books\StoreBookRequest;
use App\Http\Resources\BookResource;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Facades\Gate;

final class StoreBookController
{
    /**
     * @param  StoreBookAction  $action
     * @param  StoreBookRequest  $request
     * @param  User  $user
     * @return BookResource
     */
    public function __invoke(
        StoreBookAction $action,
        StoreBookRequest $request,
        #[CurrentUser('sanctum')] User $user
    ): BookResource {
        Gate::authorize('isAdminOrModerator');

        $book = $action($user, $request->validated());

        return BookResource::make($book);
    }
}
