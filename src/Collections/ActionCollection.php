<?php

namespace Thunk\VerbsCommands\Collections;

use Illuminate\Support\Collection;
use Thunk\VerbsCommands\Contracts\Action;

class ActionCollection extends Collection
{
    public function __construct($items = [])
    {
        parent::__construct($items);

        $this->each(
            fn ($class) => throw_unless(
                in_array(Action::class, class_implements($class)),
                new \Exception("{$class} must implement Action")
            )
        );
    }

    public function keys()
    {
        return $this->toBase()->keys();
    }
}
