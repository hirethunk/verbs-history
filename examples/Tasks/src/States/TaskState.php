<?php

namespace Thunk\VerbsCommands\Examples\Tasks\States;

use Thunk\Verbs\State;
use Thunk\VerbsCommands\Concerns\Actions;
use Thunk\VerbsCommands\Contracts\HasActions;
use Thunk\VerbsCommands\Collections\ActionCollection;
use Thunk\VerbsCommands\Examples\Tasks\Events\TaskArchived;
use Thunk\VerbsCommands\Examples\Tasks\Events\TaskAssigned;

class TaskState extends State implements HasActions
{
    use Actions;

    public static function allActions(): ActionCollection
    {
        return actions([
            'assign' => TaskAssigned::class,
            'archive' => TaskArchived::class,
        ]);
    }
}
