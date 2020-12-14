<?php

namespace Upthemedia\XssProtection;

use Illuminate\Support\ServiceProvider;

class XssProtectionProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/xssprotection.php' => config_path('xssprotection.php'),
        ], 'config');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/xssprotection.php', 'xssprotection.php'
        );
    
    }
}
