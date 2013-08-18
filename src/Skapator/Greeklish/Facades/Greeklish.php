<?php namespace Skapator\Greeklish\Facades;

use Illuminate\Support\Facades\Facade;

class Greeklish extends Facade {

    /**
    * Get the registered name of the component.
    *
    * @return string
    */
    protected static function getFacadeAccessor()
    {
        return 'greeklish';
    }

}