@props(['type' => 'submit'])

<button type="{{ $type }}"
        {{ $attributes->merge(['class' => 'w-full rounded-full bg-[#5B6E33] text-white py-3 font-medium text-sm hover:bg-[#4A5D23] transition duration-200']) }}>
    {{ $slot }}
</button>
