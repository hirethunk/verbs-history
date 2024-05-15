<?php

namespace Thunk\VerbsHistory\Facades;

use Illuminate\Support\Facades\Facade;
use Thunk\VerbsHistory\Broker;

class History extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Broker::class;
    }
}
