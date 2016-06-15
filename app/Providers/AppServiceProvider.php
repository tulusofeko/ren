<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Output;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Load menu to all view
        $menus = json_decode(file_get_contents(
            base_path() . '/resources/views/data/menu-ren.json')
        );

        view()->share('menus', $menus);

        Output::creating(function ($output) { $output->setMak(); });

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
