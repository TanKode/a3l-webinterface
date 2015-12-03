<?php
namespace A3LWebInterface\Providers;

use A3LWebInterface\Libs\Helper;
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
