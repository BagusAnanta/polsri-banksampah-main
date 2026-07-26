@props(['route', 'icon', 'label'])

@php
    $isActive = request()->routeIs($route);
@endphp

<a href="{{ route($route) }}"
   title="{{ $label }}"
   class="group relative flex h-10 w-10 items-center justify-center rounded-full transition-all duration-200
          {{ $isActive ? 'bg-olive-700 text-white' : 'text-base-content/60 hover:bg-base-300/50' }}">

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

    <!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        @if($icon === 'home')
            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
        @elseif($icon === 'trash')
            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 2.8a1.039 1.039 0 0 0-1.837-.909l-5.196 6.993L3.854 2.8a1.039 1.039 0 0 0-1.837.909l1.07 14.41m14.318 0h1.091A2.909 2.909 0 0 0 21.727 12.82V5.91c0-1.605-1.304-2.909-2.909-2.909h-6.052c.282.159.553.38.795.645l5.108 6.894c.23.308.42.643.57.995.228.894.026 1.843-.559 2.541-.79.954-2.359 1.288-3.652.281l-.423-.368" />
        @elseif($icon === 'gift')
            <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        @elseif($icon === 'book-open')
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
        @elseif($icon === 'clock')
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        @elseif($icon === 'grid')
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
        @elseif($icon === 'users')
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v-.106A12.318 12.318 0 0 1 8.25 15.75m6.75 3.378a.75.75 0 0 1-1.5 0V18M8.25 15.75A5.25 5.25 0 0 1 3 10.5v-1.5a2.25 2.25 0 0 1 2.25-2.25h.75m4.5 9a5.25 5.25 0 0 0 5.25-5.25v-1.5A2.25 2.25 0 0 0 13.5 7.5h-.75M12 8.25A5.25 5.25 0 0 0 6.75 3h-1.5A2.25 2.25 0 0 0 3 5.25v1.5" />
        @elseif($icon === 'building')
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
        @elseif($icon === 'cog')
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.592c.55 0 1.02.398 1.11.94a6.474 6.474 0 0 0 1.629 1.951c.578.523 1.272.798 1.943.798.711 0 1.406-.275 1.985-.799a6.519 6.519 0 0 0 1.628-1.95c.09-.542.56-.94 1.11-.94h2.592c.55 0 1.02.398 1.11.94a6.47 6.47 0 0 1-.604 2.05 6.588 6.588 0 0 1-1.386 1.581c-.56.456-.991.999-.991 1.632 0 .632.431 1.175.991 1.632a6.591 6.591 0 0 1 1.387 1.581 6.477 6.477 0 0 1 .604 2.051c-.09.542-.56.94-1.11.94h-2.592a1.119 1.119 0 0 0-1.11.94 6.47 6.47 0 0 1-1.629 1.95c-.578.524-1.272.799-1.943.799-.711 0-1.406-.275-1.985-.799a6.52 6.52 0 0 1-1.628-1.95 1.119 1.119 0 0 0-1.11-.94h-2.592c-.55 0-1.02.398-1.11.94a6.472 6.472 0 0 1-.604-2.05 6.588 6.588 0 0 1 1.386-1.581c.56-.456.991-.999.991-1.632 0-.632-.431-1.175-.991-1.632a6.591 6.591 0 0 1-1.387-1.581 6.477 6.477 0 0 1-.604-2.051c.09-.542.56-.94 1.11-.94h2.592a1.119 1.119 0 0 0 1.11-.94 6.47 6.47 0 0 1 1.629-1.95Zm6 0a3 3 0 1 0-6 0 3 3 0 0 0 6 0Z" />
        @elseif($icon === 'question-mark-circle')
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25v.008" />
        @elseif($icon === 'qr-code')
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 14.625a1.125 1.125 0 0 1 1.125-1.125h2.25a1.125 1.125 0 0 1 1.125 1.125v2.25a1.125 1.125 0 0 1-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125v-2.25Zm3.375 3.375v.75m-7.5-7.5v.75" />
        @else
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        @endif
    </svg> -->
    
    <span class="absolute left-12 rounded-md bg-neutral px-2 py-1 text-xs font-medium text-neutral-content opacity-0 transition-opacity group-hover:opacity-100 whitespace-nowrap z-50 shadow-lg">
        {{ $label }}
    </span>
</a>