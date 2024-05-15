@props([
    'text',
    'time',
    'isLast' => false,
])

<li class="relative flex gap-x-4">
    @unless($isLast)
        <div class="absolute left-0 top-0 flex w-6 justify-center -bottom-6">
            <div class="w-px bg-gray-200"></div>
        </div>
    @endUnless
    <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">
    <div class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300"></div>
    </div>
    <p class="flex-auto py-0.5 text-xs leading-5 text-gray-500"><span class="font-medium text-gray-900">{{ $text }}</p>
    <time datetime="2023-01-24T09:12" class="flex-none py-0.5 text-xs leading-5 text-gray-500">{{ $time }}</time>
</li>