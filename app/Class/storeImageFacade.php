<?php

namespace App\Class;

use App\Models\Images;

class storeImageFacade
{

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([app()->make('storImg'), $name], $arguments);
    }

}
