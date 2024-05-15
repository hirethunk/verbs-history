<?php

namespace Thunk\VerbsHistory\Examples\Tasks\Events;

use Thunk\Verbs\Event;
use Thunk\VerbsHistory\Attributes\VerbsInput;
use Thunk\VerbsHistory\Concerns\AttributeInputs;
use Thunk\VerbsHistory\Contracts\Action;

class TaskCreated extends Event implements Action
{
    use AttributeInputs;

    public int $author_id;

    #[VerbsInput('text', 'Task Title')]
    public string $title;

    #[VerbsInput('text', 'Task Description')]
    public string $description;

    #[VerbsInput('select', [
        'label' => 'Project',
        'options' => 'getProjects',
    ])]
    public int $project_id;

    public static function actionName(): string
    {
        return 'Create Task';
    }

    public static function actionDescription(): string
    {
        return 'Create a new task';
    }

    public static function getProjects()
    {
        return [
            1 => 'Project 1',
            2 => 'Project 2',
            3 => 'Project 3',
        ];
    }
}
