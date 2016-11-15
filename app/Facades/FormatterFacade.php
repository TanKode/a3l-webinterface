<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade as IlluminateFacade;

class FormatterFacade extends IlluminateFacade
{
    protected static function getFacadeAccessor()
    {
        return 'formatter';
    }
}
