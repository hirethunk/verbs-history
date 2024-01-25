<?php

namespace Thunk\VerbsCommands\Collections;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use ReflectionClass;
use Thunk\VerbsCommands\Attributes\VerbsInput;

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
        $input = Arr::wrap($input);

        $filtered = Arr::isAssoc($input)
            ? $this->filter(
                fn ($prop) => isset($input[$prop->getName()])
            )
            : $this->filter(
                fn ($prop) => in_array($prop->getName(), $input)
            );

        return static::make($filtered);
    }
}
