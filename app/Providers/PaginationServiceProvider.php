<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class PaginationServiceProvider extends ServiceProvider
{

    // Register: Use this method to bind services to the container, ensuring they are available for dependency injection. This is about defining how things work.

   // Boot: Use this method to configure or modify behavior after everything has been registered. This is about setting up and running things.

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
