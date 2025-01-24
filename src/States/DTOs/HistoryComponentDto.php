<?php

namespace Thunk\VerbsHistory\States\DTOs;

use Thunk\Verbs\Support\Normalization\NormalizeToPropertiesAndClassName;

class HistoryComponentDto
{
    // use NormalizeToPropertiesAndClassName;

    public function __construct(
        public string $component,
        public array $props,
    ) {}
}
