<?php

namespace App\Providers;

use App\Libs\Formatter;
use App\Libs\Helper;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->bindShared('helper', function ($app) {
            return new Helper();
        });
        $this->app->bindShared('formatter', function ($app) {
            return new Formatter();
        });
    }

    public function provides()
    {
        return [
            'helper',
            'formatter',
        ];
    }
}
