<?php

namespace Thunk\VerbsCommands\Concerns;

use Illuminate\Support\Collection;
use Thunk\Verbs\Event;
use Thunk\VerbsCommands\Collections\ActionCollection;
use Thunk\VerbsCommands\Collections\PropertyCollection;

trait Actions
{
    public function availableActions(Collection $context): ActionCollection
    {
        return self::allActions()
            ->filter(function ($action) use ($context) {
                $pending_event = $action::makeWithContext($context);

                return PropertyCollection::fromClass($action)->hasRequiredParams($context)
                    && $pending_event->isAllowed()
                    && $pending_event->isValid();
            });
    }

    public function fireAction(string $action, $input = []): Event
    {
        $action = self::allActions()->get($action);

        return $action::fireWithArbitraryInput($input);
    }
}
