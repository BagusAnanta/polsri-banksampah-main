@props(['type' => 'submit'])

<button type="{{ $type }}"
        {{ $attributes->merge(['class' => 'w-full rounded-full bg-[#14532D] text-white py-3 font-medium text-sm hover:bg-[#1B3B2B] transition duration-200']) }}>
    {{ $slot }}
</button>
