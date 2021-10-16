<?php

namespace App\Providers;

use App\Components\LogComponent;
use Illuminate\Support\ServiceProvider;

class LogComponentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('logData', function () {
            return new LogComponent();
        });
    }

    public function provides()
    {
        return [
            'logData'
        ];
    }
}
