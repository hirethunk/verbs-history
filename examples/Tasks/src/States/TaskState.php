<?php

namespace Thunk\VerbsHistory\Examples\Tasks\States;

use Thunk\Verbs\State;
use Thunk\VerbsHistory\Collections\ActionCollection;
use Thunk\VerbsHistory\Concerns\Actions;
use Thunk\VerbsHistory\Contracts\HasActions;
use Thunk\VerbsHistory\Examples\Tasks\Events\TaskArchived;
use Thunk\VerbsHistory\Examples\Tasks\Events\TaskAssigned;

class TaskState extends State implements HasActions
{
    use Actions;

    public string $status = 'new';

    public ?int $assignee = null;

    public static function allActions(): ActionCollection
    {
        return actions([
            'assign' => TaskAssigned::class,
            'archive' => TaskArchived::class,
        ]);
    }
}
