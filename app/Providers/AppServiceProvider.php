<?php

namespace App\Providers;

use App\Models\Favourite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // for beautiful pagination instead of big two arrows.

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //for counting recipes that are available in favourite.

        Paginator::useBootstrap(); // for beautiful pagination instead of big two arrows.
        view()->composer('*', function ($view) {
            if (auth()->user()) { // helps to  solve errror of null id

                $savedRecipesCount = Favourite::where('user_id', auth()->user()->id)->count();

                $view->with('savedRecipesCount', $savedRecipesCount);
            }
        });
    }
}
