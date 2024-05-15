<?php

namespace Thunk\VerbsHistory\States\Traits;

use Thunk\Verbs\Event;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Thunk\VerbsHistory\Facades\History;
use Thunk\VerbsHistory\States\DTOs\HistoryItem;
use Thunk\VerbsHistory\States\DTOs\HistoryComponentDto;
use Thunk\VerbsHistory\States\Interfaces\ExposesHistory;

trait HasHistory
{
    public array $history = [];

    public function shouldSuppress(Event|ExposesHistory $event)
    {
        return $event->metadata('suppress_history', false);
    }

    public function applyHistoryEvent(ExposesHistory $event)
    {
        if ($this->shouldSuppress($event)) {
            return $this->history;
        }

        // really we should be doing the message stuff below here instead
        // if we have a message, pass it in. If we have a component, pass it in
        array_unshift(
            $this->history,
            new HistoryItem(
                date_time: Carbon::now(),
                component: $event->asHistory(),
                message: 
            )
        );

        dump($this->history);
    }

    public function getHistory(?string $sub_history = null): array
    {
        return collect($this->history)
            ->map(
                function ($item) use ($sub_history) {
                    // $value = match (gettype($item['value'])) {
                    //     'array' => Arr::get($item, "value.$sub_history") ?? Arr::get($item, 'value.default'),
                    //     'string' => $item['value'],
                    //     'object' => $item['value'],
                    // };

                    $message = gettype($item['value'] === 'string'
                        ? $item['value']
                        : null
                    );

                    $component = is_a($item['value'], HistoryComponentDto::class)
                        ? $item['value']
                        : null;

                    $datetime = Carbon::parse($item['datetime']);

                    return new HistoryItem(
                        date_time: $datetime,
                        message: $message,
                        component: $component,
                    );
                }
            )
            ->filter()
            ->values()
            ->toArray();
    }
}
