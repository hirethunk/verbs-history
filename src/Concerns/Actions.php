<?php

namespace Thunk\VerbsCommands\Concerns;

use Illuminate\Support\Collection;
use ReflectionClass;
use Thunk\Verbs\Attributes\Autodiscovery\StateId;
use Thunk\Verbs\Event;
use Thunk\VerbsCommands\Collections\ActionCollection;
use Thunk\VerbsCommands\Collections\PropertyCollection;

trait Actions
{
    public function availableActions(?iterable $context = null): ActionCollection
    {
        $context = collect($context);

        return self::allActions()
            ->filter(function ($action) use ($context) {
                $combined_context = self::combineContextWithStates($action, $context, [$this]);
                $pending_event = $action::makeWithContext($combined_context);

                return PropertyCollection::fromClass($action)->hasRequiredParams($combined_context)
                    && $pending_event->isAllowed()
                    && $pending_event->isValid();
            });
    }

    public function fireAction(string $action, $input = []): Event
    {
        $action = self::allActions()->get($action);

        $combined_context = self::combineContextWithStates($action, $input, [$this]);

        return $action::fireWithArbitraryInput($combined_context);
    }

    protected static function combineContextWithStates(
        string $fqcn,
        iterable $context,
        ?iterable $states = []
    ): Collection {
        $context = collect($context);
        $reflector = new ReflectionClass($fqcn);

        $inputs = collect($reflector->getProperties())
            ->mapWithKeys(
                function ($input) {
                    $attributes = $input->getAttributes(StateId::class);

                    return empty($attributes) || empty($attributes[0]->getArguments())
                        ? []
                        : [$attributes[0]->getArguments()[0] => $input->getName()];
                }
            );

        $state_inputs = collect($states)
            ->mapWithKeys(function ($state) use ($inputs) {
                $input_name = $inputs->get(get_class($state));

                return $input_name
                    ? [$input_name => $state->id]
                    : [];
            });

        return $context->merge($state_inputs);
    }
}
