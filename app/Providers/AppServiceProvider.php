<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            \App\Repositories\Admin\User\UserRepositoryInterface::class, \App\Repositories\Admin\User\UserRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Admin\Artist\ArtistRepositoryInterface::class, \App\Repositories\Admin\Artist\ArtistRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Admin\Country\CountryRepositoryInterface::class, \App\Repositories\Admin\Country\CountryRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Admin\Category\CategoryRepositoryInterface::class, \App\Repositories\Admin\Category\CategoryRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Admin\Video\VideoRepositoryInterface::class, \App\Repositories\Admin\Video\VideoRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Admin\Film\FilmRepositoryInterface::class, \App\Repositories\Admin\Film\FilmRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Admin\CategoryFilm\CategoryFilmRepositoryInterface::class, \App\Repositories\Admin\CategoryFilm\CategoryFilmRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Admin\ArtistFilm\ArtistFilmRepositoryInterface::class, \App\Repositories\Admin\ArtistFilm\ArtistFilmRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Admin\News\NewsRepositoryInterface::class, \App\Repositories\Admin\News\NewsRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Admin\ManageSlider\ManageSliderRepositoryInterface::class, \App\Repositories\Admin\ManageSlider\ManageSliderRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Admin\SavedVideo\SavedVideoRepositoryInterface::class, \App\Repositories\Admin\SavedVideo\SavedVideoRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Admin\Comment\CommentRepositoryInterface::class, \App\Repositories\Admin\Comment\CommentRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Admin\InfoVideo\InfoVideoRepositoryInterface::class, \App\Repositories\Admin\InfoVideo\InfoVideoRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
