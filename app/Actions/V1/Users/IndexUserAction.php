<?php

declare(strict_types=1);

namespace App\Actions\V1\Users;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

final class IndexUserAction
{
    /**
     * Returns paginated users
     *
     * @return LengthAwarePaginator
     */
    public function __invoke(): LengthAwarePaginator
    {
        return User::paginate(columns: [
            'id',
            'name'
        ])->appends(request()->query());
    }
}
