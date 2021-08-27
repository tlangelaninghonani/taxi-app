<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\InternalAdmin;
use Illuminate\Support\Facades\Hash;

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
        $prefix = "";
        $links = array(
            "js" => "$prefix/js/app.js",
            "css" => "$prefix/css/app.css",
            "hash" => new Hash(),
            "internalAdmin" => InternalAdmin::find(1)
        );
        View::share("links", $links);
    }
}
