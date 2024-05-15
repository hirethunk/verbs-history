<?php

namespace Thunk\VerbsHistory\States\Interfaces;

interface ExposesHistory
{
    public function getHistoryMessage(): array|string;
}
