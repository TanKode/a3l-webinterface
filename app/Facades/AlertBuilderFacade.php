<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade as IlluminateFacade;

class AlertBuilderFacade extends IlluminateFacade
{
    protected static function getFacadeAccessor()
    {
        return 'alertbuilder';
    }
}