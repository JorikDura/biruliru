<?php

declare(strict_types=1);

use App\Console\Commands\DeleteNonVerifiedUsersCommand;

Schedule::command(DeleteNonVerifiedUsersCommand::class)->hourly();
