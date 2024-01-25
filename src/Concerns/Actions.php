<?php

namespace Thunk\VerbsCommands\Concerns;

use Thunk\Verbs\Event;
use Thunk\VerbsCommands\Collections\ActionCollection;

trait Actions
{
    public function availableActions(array $context = []): ActionCollection
    {
        return self::allActions()
            ->filter(function ($action) use ($context) {

                $event = $action::makeWithContext($context);

                return $event->hasAllRequiredParams()
                    && $event->isAllowed()
                    && $event->isValid();
            });
    }

    public function fireAction(string $action, $input = []): Event
    {
        $action = self::allActions()->get($action);

        return $action::fireWithArbitraryInput($input);
    }
}
