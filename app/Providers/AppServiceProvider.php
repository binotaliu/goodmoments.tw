<?php

declare(strict_types=1);

namespace App\Providers;

use App\Paginator\LengthAwarePaginator;
use Illuminate\Pagination\LengthAwarePaginator as IlluminatePaginator;
use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app->bind(IlluminatePaginator::class, LengthAwarePaginator::class);

        Route::macro('is', function (string $pattern) {
            return Str::is($pattern, $this->uri);
        });
    }
}
