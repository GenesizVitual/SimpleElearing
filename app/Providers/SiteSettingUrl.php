<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SiteSettingUrl extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path() . '/Helper/SettingUrl.php';
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
