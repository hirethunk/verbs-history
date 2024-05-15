@props([
    'dto'
])

<li class="relative flex gap-x-4">
    @unless($isLast)
        <div class="absolute left-0 top-0 flex w-6 justify-center -bottom-6">
            <div class="w-px bg-gray-200"></div>
        </div>
    @endUnless
    
    <!-- take the array from the DTO and pass it in here. but also look up what the ComponentAttributeBag function is actually called in blade -->
    <x-dynamic-component :component="$dto->component" :attributes="new ComponentAttributeBag($dto->props)" />

    <x-some-specified-comonent prop1="value1" prop2="value2" />
</li>