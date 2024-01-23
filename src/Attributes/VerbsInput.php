<?php

namespace Thunk\VerbsCommands\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class VerbsInput
{
    protected $input_types = [
        'text',
        'select',
    ];

    public function __construct(
        public string $input_type,
        public array $properties,
    ) {
        if (! in_array($this->input_type, $this->input_types)) {
            throw new \Exception("Invalid input type: {$this->input_type}");
        }
    }
}
