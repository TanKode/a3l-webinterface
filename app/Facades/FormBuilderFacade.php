<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade as IlluminateFacade;

class FormBuilderFacade extends IlluminateFacade
{
    protected static function getFacadeAccessor()
    {
        return 'formbuilder';
    }
}
