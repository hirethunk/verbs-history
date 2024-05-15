<?php

namespace Thunk\VerbsHistory\Examples\Tasks\Events;

use Thunk\Verbs\Event;
use Thunk\VerbsHistory\Concerns\AttributeInputs;
use Thunk\VerbsHistory\Contracts\Action;

abstract class ActionEvent extends Event implements Action
{
    use AttributeInputs;

    abstract public static function actionName(): string;

    abstract public static function actionDescription(): string;
}
