<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade as IlluminateFacade;

class FilterBuilderFacade extends IlluminateFacade
{
    protected static function getFacadeAccessor()
    {
        return 'filterbuilder';
    }
}
