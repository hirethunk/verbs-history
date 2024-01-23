<?php

namespace Thunk\VerbsCommands\Facades;

use Illuminate\Support\Facades\Facade;
use Thunk\VerbsCommands\Broker;

class Commands extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Broker::class;
    }
}
