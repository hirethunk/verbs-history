<?php

namespace Thunk\VerbsCommands\Collections;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use ReflectionClass;
use Thunk\VerbsCommands\Attributes\VerbsInput;
use Thunk\VerbsCommands\Exceptions\MissingPropertyException;

class PropertyCollection extends Collection
{
    public static function fromClass(string $class): static
    {
        $reflect = new ReflectionClass($class);

        return static::make($reflect->getProperties());
    }

    public function public(): PropertyCollection
    {
        return $this->filter(fn ($prop) => $prop->isPublic());
    }

    public function input(bool $is_input = true): static
    {
        return $this->filter(function ($prop) use ($is_input) {
            $attributes = $prop->getAttributes(VerbsInput::class);

            return $is_input
                ? ! empty($attributes)
                : empty($attributes);
        });
    }

    public function missingFrom(iterable $input): static
    {
        $input = Arr::wrap($input);

        $filtered = Arr::isAssoc($input)
            ? $this->filter(
                fn ($prop) => ! isset($input[$prop->getName()])
            )
            : $this->filter(
                fn ($prop) => ! in_array($prop->getName(), $input)
            );

        return static::make($filtered);
    }

    public function presentIn(iterable $input): static
    {
        // take context object and trim it down so that it only has
        // valid properties

        $input = collect($input)->toArray();

        $filtered = Arr::isAssoc($input)
            ? $this->filter(
                fn ($prop) => isset($input[$prop->getName()])
            )
            : $this->filter(
                fn ($prop) => in_array($prop->getName(), $input)
            );

        return static::make($filtered);
    }

    public function hasRequiredParams(Collection $context): bool
    {

        [$valid, $missing] = $this
            ->input(false)
            ->reduceSpread(
                function (
                    bool $everything_has_been_valid,
                    Collection $missing_params,
                    $current_param
                ) use ($context) {
                    if (
                        ! $context->has($current_param->getName())
                        && $current_param->getName() !== 'id'
                    ) {
                        $everything_has_been_valid = false;
                        $missing_params->push($current_param);
                    }

                    return [$everything_has_been_valid, $missing_params];
                },
                true,
                collect(),
            );

        return $valid;
    }
}

// function ($prop, $name) {
//     if (! $this->has($name)) {
//         throw new MissingPropertyException(
//             missing: $prop
//         );
//     }
// }
