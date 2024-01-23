<?php

use Thunk\Verbs\State;
use Thunk\VerbsCommands\Collections\ActionCollection;
use Thunk\VerbsCommands\Concerns\Actions;
use Thunk\VerbsCommands\Contracts\HasActions;

class TaskState extends State implements HasActions
{
    use Actions;

    public static function allActions(): ActionCollection
    {
        return actions([
            'assign' => TaskAssigned::class,
        ]);
    }
}
