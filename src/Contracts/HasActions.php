<?php

namespace Thunk\VerbsCommands\Contracts;

use Thunk\Verbs\Event;
use Thunk\VerbsCommands\Collections\ActionCollection;

interface HasActions
{
    public static function allActions(): ActionCollection;

    public function availableActions(array $context = []): ActionCollection;

    public function fireAction(string $action): Event;
}
