<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

final class DeleteNonVerifiedUsersCommand extends Command
{
    protected $signature = 'delete:non-verified-users';

    protected $description = 'Deletes unverified users';

    public function handle(): void
    {
        User::where('email_verified_at', null)
            ->where('updated_at', '<', now()->subDay())
            ->get()
            ->each(fn (User $user) => $user->delete());
    }
}
