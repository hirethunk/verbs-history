<?php

namespace Thunk\VerbsCommands\Examples\Tasks\Events;

use Thunk\Verbs\Event;
use Thunk\VerbsCommands\Concerns\AttributeInputs;
use Thunk\VerbsCommands\Contracts\Action;

abstract class ActionEvent extends Event implements Action
{
    use AttributeInputs;

    abstract public static function actionName(): string;

    abstract public static function actionDescription(): string;
}
