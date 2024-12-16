<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureModels();
        $this->configureCommands();
        $this->bindUserLink();
        $this->defineGates();
    }

    /**
     * Configures models
     * They should be strict
     *
     * @return void
     */
    public function configureModels(): void
    {
        Model::shouldBeStrict();
    }

    /**
     * Configures commands
     *
     * @return void
     */
    public function configureCommands(): void
    {
        DB::prohibitDestructiveCommands(app()->isProduction());
    }

    /**
     * New route binding for App\Models\User model
     * using "custom_link" or "id"
     *
     * @return void
     */
    public function bindUserLink(): void
    {
        Route::bind('user', function (string $value): User {
            return User::when(
                value: is_numeric($value),
                callback: static function (Builder $query) use ($value) {
                    $query->where('id', $value);
                }
            )->orWhere('custom_link', $value)->firstOrFail();
        });
    }

    public function defineGates(): void
    {
        Gate::define('isAdminOrModerator', static function (User $user): bool {
            return $user->isModerator() || $user->isAdmin();
        });
    }
}
