<?php

namespace App\Providers;

use App\Libs\AlertBuilder;
use App\Libs\FormBuilder;
use Illuminate\Support\ServiceProvider;

class HtmlBuilderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->bindShared('alertbuilder', function($app) {
            return new AlertBuilder($app['html']);
        });
        $this->app->bindShared('formbuilder', function ($app) {
            $form = new FormBuilder($app['html'], $app['url'], $app['session.store']->getToken());
            return $form->setSessionStore($app['session.store']);
        });
    }

    public function provides()
    {
        return [
            'alertbuilder',
            'formbuilder',
        ];
    }
}
