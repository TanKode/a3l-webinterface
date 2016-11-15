<?php

namespace App\Providers;

use App\Libs\FormBuilder;
use App\Libs\FilterBuilder;
use App\Libs\MarkExtra;
use Illuminate\Support\ServiceProvider;

class HtmlBuilderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->bindShared('formbuilder', function($app) {
            $form = new FormBuilder($app['html'], $app['url'], $app['session.store']->getToken());
            return $form->setSessionStore($app['session.store']);
        });
        $this->app->bindShared('filterbuilder', function($app) {
            return new FilterBuilder($app['formbuilder']);
        });

        $this->app->bindShared('markextra', function($app) {
            return new MarkExtra();
        });
    }

    public function provides()
    {
        return [
            'formbuilder',
            'filterbuilder',
            'markextra'
        ];
    }
}
