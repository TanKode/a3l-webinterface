<?php

namespace App\Providers;

use App\Libs\Helper;
use App\Libs\Formatter;
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
