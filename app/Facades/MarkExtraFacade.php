<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade as IlluminateFacade;

class MarkExtraFacade extends IlluminateFacade
{
    protected static function getFacadeAccessor()
    {
        return 'markextra';
    }
}
