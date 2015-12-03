<?php
namespace A3LWebInterface\Facades;

use Illuminate\Support\Facades\Facade as IlluminateFacade;

class HelperFacade extends IlluminateFacade
{
    protected static function getFacadeAccessor()
    {
        return 'helper';
    }
}
