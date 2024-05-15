<?php

namespace Thunk\VerbsHistory\States\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Thunk\Verbs\Event;
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

        array_unshift(
            $this->history,
            [
                'message' => $event->getHistoryMessage(),
                'datetime' => now()->toDateTimeString(),
            ]
        );
    }

    public function getHistory(?string $sub_history = null): array
    {
        return collect($this->history)
            ->map(
                function ($item) use ($sub_history) {
                    $message = match (gettype($item['message'])) {
                        'array' => Arr::get($item, "message.$sub_history") ?? Arr::get($item, 'message.default'),
                        'string' => $item['message'],
                    };

                    $datetime = Carbon::parse($item['datetime']);

                    return (object) [
                        'message' => $message,
                        'datetime' => $datetime,
                        'human_time' => $datetime->diffForHumans(),
                    ];
                }
            )
            ->filter(fn ($item) => $item->message)
            ->values()
            ->toArray();
    }
}
