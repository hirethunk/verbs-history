<?php

namespace Thunk\VerbsCommands\Concerns;

use Illuminate\Support\Collection;
use Thunk\Verbs\Support\PendingEvent;
use Thunk\VerbsCommands\Collections\PropertyCollection;
use Thunk\VerbsCommands\Exceptions\MissingInputException;
use Thunk\VerbsCommands\Exceptions\MissingPropertyException;

trait AttributeInputs
{
    public static function fireWithArbitraryInput($input)
    {
        $valid_input = static::validateUserInput($input);

        return static::fire(...$valid_input);
    }

    public static function makeWithContext(Collection $context, iterable $states = []): PendingEvent
    {
        // @todo: All of this doesnt work
        // it's pseudo code for now
        // [SomeState::class => 'some_state_id', SomeOtherState::class => 'some_other_state_id']
        $inputs_that_are_state_inputs = $this->inputs()->mapWithKeys(
            function ($input) {
                $attributes = $this->getAttributesForInput($input, StateId::class);

                return empty($attributes)
                    ? null
                    : [$attributes->first()->getArguments()[0] => $input->getName()];
            }
        );

        // ['some_state_id' => 1, 'some_other_state_id' => 2]
        $state_inputs = collect($states)
            ->mapWithKeys(function ($state) use ($inputs_that_are_state_inputs) {
                $input_name = $inputs_that_are_state_inputs->get(get_class($state));

                return $input_name
                    ? [$input_name => $state->id]
                    : null;
            });

        $combined_context = $context->merge($state_inputs);

        $valid_input_keys = PropertyCollection::fromClass(static::class)
            ->presentIn($combined_context)
            ->map(fn ($prop) => $prop->getName());

        $valid_input = $combined_context->only($valid_input_keys);

        if ($valid_input->isEmpty()) {
            return static::make()->hydrate([]);
        }

        return static::make(...$valid_input);
    }

    public static function validateUserInput(iterable $input): iterable
    {
        $props = PropertyCollection::fromClass(static::class)
            ->filter(fn ($i) => $i->getName() !== 'id');

        $missing_props = $props->input(false)->missingFrom($input);
        if ($missing_props->isNotEmpty()) {
            throw new MissingPropertyException(
                missing: $missing_props->toArray()
            );
        }

        $missing_input = $props->input()->missingFrom($input);
        if ($missing_input->isNotEmpty()) {
            throw new MissingInputException(
                missing: $missing_input->toArray()
            );
        }

        return $input;
    }

    public static function missingFields($input)
    {
        return collect(static::fillableNames())
            ->reject(fn ($field) => isset($input[$field]))
            ->toArray();
    }

    public function hasRequiredParams($class_name)
    {
        $props = PropertyCollection::fromClass($class_name);

        $non_inputs = $props->input(false);

        $non_inputs->each(function ($prop, $name) {
            if (! $this->has($name)) {
                throw new MissingPropertyException(
                    missing: $prop
                );
            }
        });

        return $this;
    }
}
