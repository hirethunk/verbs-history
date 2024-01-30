<?php

namespace Thunk\VerbsCommands\Examples\Tasks\Events;

use Thunk\Verbs\Event;
use Thunk\VerbsCommands\Contracts\Action;
use Thunk\Verbs\Attributes\Autodiscovery\StateId;
use Thunk\VerbsCommands\Concerns\AttributeInputs;
use Thunk\VerbsCommands\Examples\Tasks\States\TaskState;

class TaskArchived extends ActionEvent
{
    #[StateId(TaskState::class)]
    public int $task_id;

    public function apply(TaskState $state)
    {
        $state->status = 'archived';
    }

    public static function actionName(): string
    {
        return 'Archive Task';
    }

    public static function actionDescription(): string
    {
        return 'Archive this task (you can always restore it later)';
    }
}
