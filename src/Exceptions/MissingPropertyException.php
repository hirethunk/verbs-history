<?php

namespace Thunk\VerbsCommands\Exceptions;

use Exception;

class MissingPropertyException extends Exception
{
    public function __construct(public array $missing)
    {
        $message = $this->message();

        parent::__construct($message);
    }

    public function message(): string
    {
        return "Missing properties: " . implode(', ', $this->missing);
    }
}
