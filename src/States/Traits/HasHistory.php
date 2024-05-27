<?php

namespace Thunk\VerbsHistory\States\Traits;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Thunk\Verbs\Event;
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

        $normalized = is_array($item)
            ? collect($item)->map(fn ($item) => $this->normalizeToHistoryItem($item))
            : collect(['default' => $this->normalizeToHistoryItem($item)]);

        $this->history->prepend(
            $normalized
        );
    }

    protected function normalizeToHistoryItem(string|HistoryComponentDto|null $item): HistoryItem
    {
        $message = gettype($item) === 'string'
            ? $item
            : null;

        $component = is_a($item, HistoryComponentDto::class)
            ? $item
            : null;

        return new HistoryItem(
            date_time: Carbon::now(),
            component: $component,
            message: $message,
        );
    }

    public function getHistory(?string $sub_history = 'default'): Collection
    {
        $this->history ??= collect();

        $history = collect($this->history)
            ->map(
                function (Collection $item) use ($sub_history) {
                    return $item->get($sub_history, $item->get('default'));
                }
            )
            ->filter()
            ->values();

        return $history;
    }
}
