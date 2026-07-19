@props(['label', 'name', 'type' => 'text', 'required' => false, 'placeholder' => ''])

<div class="flex flex-col gap-1.5 mb-4">
    <label for="{{ $name }}" class="text-sm font-medium text-stone-700">
        {{ $label }}
        @if($required) <span class="text-red-500">*</span> @endif
    </label>
    @if($type === 'select')
        <select name="{{ $name }}" id="{{ $name }}"
                {{ $attributes->merge(['class' => 'w-full rounded-xl bg-[#EADDCD] px-4 py-3 text-sm text-stone-800 placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-[#5B6E33] focus:ring-offset-2 focus:ring-offset-[#FAF5EB] transition']) }}>
            {{ $slot }}
        </select>
    @elseif($type === 'password')
        <div class="relative">
            <input type="password" name="{{ $name }}" id="{{ $name }}"
                   placeholder="{{ $placeholder }}"
                   {{ $attributes->merge(['class' => 'w-full rounded-xl bg-[#EADDCD] px-4 py-3 text-sm text-stone-800 placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-[#5B6E33] focus:ring-offset-2 focus:ring-offset-[#FAF5EB] transition pr-12']) }} />
            <button type="button" onclick="togglePassword('{{ $name }}')"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-stone-400 hover:text-stone-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </button>
        </div>
    @elseif($type === 'tel')
        <input type="tel" name="{{ $name }}" id="{{ $name }}"
               placeholder="{{ $placeholder }}"
               {{ $attributes->merge(['class' => 'w-full rounded-xl bg-[#EADDCD] px-4 py-3 text-sm text-stone-800 placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-[#5B6E33] focus:ring-offset-2 focus:ring-offset-[#FAF5EB] transition']) }} />
    @else
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
               placeholder="{{ $placeholder }}"
               {{ $attributes->merge(['class' => 'w-full rounded-xl bg-[#EADDCD] px-4 py-3 text-sm text-stone-800 placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-[#5B6E33] focus:ring-offset-2 focus:ring-offset-[#FAF5EB] transition']) }} />
    @endif
    @error($name)
        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
    @enderror
</div>
