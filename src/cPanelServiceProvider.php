<?php

namespace Naif\cPanelMail;

use Illuminate\Support\ServiceProvider;

class cPanelServiceProvider extends ServiceProvider
{
    
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes(['swalker2.cpanel']);
    }
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/Config.php', 'Config'
        );

        $this->app->singleton(cPanel::class, function () {
            return new cPanel();
        });
    }
}
