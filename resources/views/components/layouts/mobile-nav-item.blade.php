@props(['route', 'icon', 'label'])

@php
    $isActive = request()->routeIs($route);
@endphp

<a href="{{ route($route) }}"
   class="flex flex-col items-center gap-0.5 px-3 py-1 text-xs font-medium transition-colors
          {{ $isActive ? 'text-[#14532D]' : 'text-base-content/50 hover:text-base-content/80' }}">

    <div class="flex items-center justify-center w-9 h-9 rounded-full transition-colors
                {{ $isActive ? 'bg-[#14532D]' : '' }}">
        @if($icon === 'home')
            <span class="material-symbols-outlined {{ $isActive ? 'text-white' : '' }}">home</span>
        @elseif($icon === 'trash')
            <span class="material-symbols-outlined {{ $isActive ? 'text-white' : '' }}">delete</span>
        @elseif($icon === 'gift')
            <span class="material-symbols-outlined {{ $isActive ? 'text-white' : '' }}">confirmation_number</span>
        @elseif($icon === 'book-open')
            <span class="material-symbols-outlined {{ $isActive ? 'text-white' : '' }}">import_contacts</span>
        @elseif($icon === 'clock')
            <span class="material-symbols-outlined {{ $isActive ? 'text-white' : '' }}">history</span>
        @elseif($icon === 'qr-code')
            <span class="material-symbols-outlined {{ $isActive ? 'text-white' : '' }}">qr_code</span>
        @elseif($icon === 'grid')
            <span class="material-symbols-outlined {{ $isActive ? 'text-white' : '' }}">dashboard</span>
        @elseif($icon === 'users')
            <span class="material-symbols-outlined {{ $isActive ? 'text-white' : '' }}">people</span>
        @elseif($icon === 'building')
            <span class="material-symbols-outlined {{ $isActive ? 'text-white' : '' }}">domain</span>
        @elseif($icon === 'cog')
            <span class="material-symbols-outlined {{ $isActive ? 'text-white' : '' }}">settings</span>
        @else
            <span class="material-symbols-outlined {{ $isActive ? 'text-white' : '' }}">menu</span>
        @endif
    </div>

    <span>{{ $label }}</span>
</a>