<?php

namespace Thunk\VerbsCommands\Concerns;

use Illuminate\Support\Collection;
use Thunk\Verbs\Event;

trait Actions
{
    public function availableActions(array $context = []): Collection
    {
        return collect(self::allActions())
        ->filter(function ($action) {
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
