<?php

namespace Thunk\VerbsHistory\States\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Thunk\Verbs\Event;
use Thunk\VerbsHistory\Facades\History;
use Thunk\VerbsHistory\States\DTOs\HistoryComponentDto;
use Thunk\VerbsHistory\States\DTOs\HistoryItem;
use Thunk\VerbsHistory\States\Interfaces\ExposesHistory;

trait HasHistory
{
    public ?Collection $history = null;

    public function shouldSuppress(Event|ExposesHistory $event)
    {
        return $event->metadata('suppress_history', false);
    }

    public function applyHistoryEvent(ExposesHistory $event)
    {
        $this->history ??= collect();
        if ($this->shouldSuppress($event)) {
            return $this->history;
        }

        $item = $event->asHistory();

        $message = gettype($item) === 'string'
            ? $item
            : null;

        $component = is_a($item, HistoryComponentDto::class)
            ? $item
            : null;

        $this->history->prepend(
            new HistoryItem(
                date_time: Carbon::now(),
                component: $component,
                message: $message,
            )
        );
    }

    public function getHistory(?string $sub_history = null): Collection
    {
        $this->history ??= collect();

        return $this->history;
        // dump($this->history);

        // return collect($this->history)
        //     ->map(
        //         function ($item) {
        //             // $value = match (gettype($item['value'])) {
        //             //     'array' => Arr::get($item, "value.$sub_history") ?? Arr::get($item, 'value.default'),
        //             //     'string' => $item['value'],
        //             //     'object' => $item['value'],
        //             // };

        //             return $item;
        //         }
        //     )
        //     ->filter()
        //     ->values()
        //     ->toArray();
    }
}
