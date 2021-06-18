<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['client.layouts.master', 'client.category', 'client.create-film', 'client.edit-film'], 'App\Http\ViewComposers\MasterClientComposer');
        View::composer(['client.home'], 'App\Http\ViewComposers\HomeClientComposer');
    }
}
