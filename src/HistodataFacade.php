<?php

namespace Taecontrol\Histodata;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Taecontrol\Histodata\Histodata
 */
class HistodataFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'histodata';
    }
}
