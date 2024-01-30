<?php

namespace Thunk\VerbsCommands\Examples\Tasks\Events;

use Thunk\Verbs\Event;
use Thunk\VerbsCommands\Contracts\Action;
use Thunk\VerbsCommands\Concerns\AttributeInputs;

class TaskArchived extends ActionEvent
{
    public static function actionName(): string
    {
        return 'Archive Task';
    }

    public static function actionDescription(): string
    {
        return 'Archive this task (you can always restore it later)';
    }
}