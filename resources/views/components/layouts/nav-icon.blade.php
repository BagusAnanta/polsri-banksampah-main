@props(['route', 'icon', 'label'])

@php
    $isActive = request()->routeIs($route);
@endphp

<a href="{{ route($route) }}"
   title="{{ $label }}"
   class="group relative flex h-10 w-10 items-center justify-center rounded-full transition-all duration-200
          {{ $isActive ? 'bg-[#14532D] text-white' : 'text-base-content/60 hover:bg-[#F3F8F4]' }}">

    <div>
        @if($icon === 'home')
            <span class="material-symbols-outlined">home</span>
        @elseif($icon === 'trash')
            <span class="material-symbols-outlined">delete</span>
        @elseif($icon === 'gift')
            <span class="material-symbols-outlined">confirmation_number</span>
        @elseif($icon === 'book-open')
            <span class="material-symbols-outlined">import_contacts</span>
        @elseif($icon === 'clock')
            <span class="material-symbols-outlined">history</span>
        @elseif($icon === 'qr-code')
            <span class="material-symbols-outlined">qr_code</span>
        @elseif($icon === 'grid')
            <span class="material-symbols-outlined">dashboard</span>
        @elseif($icon === 'users')
            <span class="material-symbols-outlined">people</span>
        @elseif($icon === 'building')
            <span class="material-symbols-outlined">domain</span>
        @elseif($icon === 'cog')
            <span class="material-symbols-outlined">settings</span>
        @elseif($icon === 'question-mark-circle')
            <span class="material-symbols-outlined">help</span>
        @else
            <span class="material-symbols-outlined">menu</span>
        @endif
    </div>
    
    <span class="absolute left-12 rounded-md bg-neutral px-2 py-1 text-xs font-medium text-neutral-content opacity-0 transition-opacity group-hover:opacity-100 whitespace-nowrap z-50 shadow-lg">
        {{ $label }}
    </span>
</a>