<?php
namespace App\Providers;

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
    }

    public function provides()
    {
        return [
            'helper',
        ];
    }
}
