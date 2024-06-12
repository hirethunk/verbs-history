<?php

namespace Thunk\VerbsHistory\States\Interfaces;

use Thunk\VerbsHistory\States\DTOs\HistoryComponentDto;

interface ExposesHistory
{
    public function asHistory(): array|string|HistoryComponentDto;
}
