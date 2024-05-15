<?php

namespace Thunk\VerbsHistory\States\DTOs;
use Illuminate\Support\Carbon;
use Thunk\Verbs\SerializedByVerbs;
use Thunk\VerbsHistory\States\DTOs\HistoryComponentDto;
use Thunk\Verbs\Support\Normalization\NormalizeToPropertiesAndClassName;

class HistoryItem implements SerializedByVerbs
{
    use NormalizeToPropertiesAndClassName;

    public function __construct(
        public Carbon $date_time,
        public ?HistoryComponentDto $component = null,
        public ?string $message = null,
    ) {
    }

    public function humanTime()
    {
        return $this->date_time->diffForHumans();
    }
}