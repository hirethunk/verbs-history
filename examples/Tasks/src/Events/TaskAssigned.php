<?php

namespace Thunk\VerbsCommands\Examples\Tasks\Events;

use Thunk\Verbs\Attributes\Autodiscovery\StateId;
use Thunk\VerbsCommands\Examples\Tasks\States\TaskState;

class TaskAssigned extends ActionEvent
{
    #[StateId(TaskState::class)]
    public int $task_id;
    
    public static function actionName(): string
    {
        return 'Assign Task';
    }

    public static function actionDescription(): string
    {
        return 'Assign this task to a user';
    }
}
