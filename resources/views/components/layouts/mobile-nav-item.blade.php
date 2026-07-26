@props(['route', 'icon', 'label'])

@php
    $isActive = request()->routeIs($route);
@endphp

<a href="{{ route($route) }}"
   class="flex flex-col items-center gap-0.5 px-3 py-1 text-xs font-medium transition-colors
          {{ $isActive ? 'text-olive-700' : 'text-base-content/50 hover:text-base-content/80' }}">

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
        @else
            <span class="material-symbols-outlined">menu</span>
        @endif
    </div>

    <span>{{ $label }}</span>
</a>
