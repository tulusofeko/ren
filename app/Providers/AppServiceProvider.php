<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB, Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         DB::listen(function ($query) {
            Log::debug($query->sql);
            // $query->sql
            // $query->bindings
            // $query->time
        });

        // Load menu to all view
        $menus = json_decode(file_get_contents(
            base_path() . '/resources/views/data/menu-ren.json')
        );

        view()->share('menus', $menus);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
