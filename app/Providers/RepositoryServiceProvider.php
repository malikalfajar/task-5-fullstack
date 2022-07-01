<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Article\ArticleRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Article\EloquentArticleRepository;
use App\Repositories\Category\EloquentCategoryRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            CategoryRepository::class,
            EloquentCategoryRepository::class
        );

        $this->app->bind(
            ArticleRepository::class,
            EloquentArticleRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
