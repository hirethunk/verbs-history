<?php

namespace Thunk\VerbsCommands\Exceptions;

use Exception;

class MissingInputException extends Exception
{
    public function __construct(
        public array $missing
    ) {
    }
}
