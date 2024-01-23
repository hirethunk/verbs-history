<?php

namespace Thunk\VerbsCommands\Contracts;

interface Action
{
    public static function actionName(): string;

    public static function actionDescription(): string;
}
