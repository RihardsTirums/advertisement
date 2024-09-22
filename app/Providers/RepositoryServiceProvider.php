<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\CategoryRepository;
use App\Repositories\DatabaseCategoryRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Bind the CategoryRepository interface to the DatabaseCategoryRepository implementation
        $this->app->bind(CategoryRepository::class, DatabaseCategoryRepository::class);
    }
}
