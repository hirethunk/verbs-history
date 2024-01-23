<?php

namespace Thunk\VerbsCommands;

class VerbsCommandRegistry
{
    public array $commands = [];

    public function register($title, $classname)
    {
        if (isset($this->commands[$title])) {
            throw new \Exception("Command already registered: {$title}");
        }

        $this->commands[$title] = $classname;
    }

    public function get($title)
    {
        if (! isset($this->commands[$title])) {
            throw new \Exception("Command not registered: {$title}");
        }

        return $this->commands[$title];
    }
}
