<?php

namespace Thunk\VerbsCommands\Examples\Tasks\Events;

use Thunk\VerbsCommands\Attributes\VerbsInput;
use Thunk\Verbs\Attributes\Autodiscovery\StateId;
use Thunk\VerbsCommands\Examples\Tasks\States\TaskState;

class TaskAssigned extends ActionEvent
{
    #[StateId(TaskState::class)]
    public int $task_id;

    #[VerbsInput('select', [
        'label' => 'Assignee',
        'options' => 'getAssignees',
    ])]
    public int $assignee_id;

    public function getAssignees()
    {
        return [
            1 => 'JDaniel',
            2 => 'Jacob',
            3 => 'John',
        ];
    }

    public function apply(TaskState $state)
    {
        $state->assignee = $this->assignee_id;
    }
    
    public static function actionName(): string
    {
        return 'Assign Task';
    }

    public static function actionDescription(): string
    {
        return 'Assign this task to a user';
    }
}
