<?php

namespace Thunk\VerbsCommands\Concerns;

use Thunk\VerbsCommands\Collections\PropertyCollection;
use Thunk\VerbsCommands\Exceptions\MissingInputException;
use Thunk\VerbsCommands\Exceptions\MissingPropertyException;

trait AttributeInputs
{
    public static function fireWithArbitraryInput($input)
    {
        $validInput = static::validateProperties($input);

        return static::fire(...$validInput);
    }

    public static function makeWithContext(array $context): static
    {
        $validInput = PropertyCollection::fromClass(static::class)
            ->onlyValidProperties($context)
            ->toArray();

        return static::make(...$validInput)
            ->ensureWeHaveAllThePropertiesThatAreNotInputtable($context);
    }

    public static function validateUserInput($input): PropertyCollection
    {
        $props = PropertyCollection::fromClass(static::class);

        if ($missing_props = $props->input(false)->missingFrom($input)) {
            throw new MissingPropertyException(
                missing: $missing_props->toArray()
            );
        }

        if ($missing_input = $props->input()->missingFrom($input)) {
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
}
