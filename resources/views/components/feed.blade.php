@props([
    'state',
    'subHistory' => null,
])

<div>
    <ul role="list" class="space-y-6">
        @foreach ($state->getHistory() as $history_item)
            <x-verbs::item
                :text="$history_item->message"
                :time="$history_item->human_time"
                :isLast="$loop->last"
            />
        @endforeach
    </ul>
</div>
