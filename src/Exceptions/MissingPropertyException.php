<?php

namespace Thunk\VerbsCommands\Exceptions;

use Exception;

class MissingPropertyException extends Exception
{
    public function __construct(
        public array $missing
    ) {
    }
}
