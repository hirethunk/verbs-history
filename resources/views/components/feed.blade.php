@props([
    'state',
    'subHistory' => null,
])

<div>
    <ul role="list" class="space-y-6">
        {{--
        @foreach ($state->getHistory() as $history_item)
            @if($history_item->component)
                <x-verbs::custom-item
                    :dto="$history_item"
                />
            @else
                <x-verbs::item
                    :text="$history_item->message"
                    :time="$history_item->humanTime()"
                    :isLast="$loop->last"
                />
            @endif
        @endforeach
        --}}
    </ul>
</div>
