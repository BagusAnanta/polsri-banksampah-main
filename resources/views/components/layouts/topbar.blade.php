{{--
    Topbar: logo + pill nav + search/notif/logout + user menu.
    Simpan di: resources/views/components/layouts/topbar.blade.php
--}}

<header class="flex items-center justify-between border-b border-base-300/40 px-4 py-3 sm:px-6">

    <div class="flex items-center gap-2">
        <img src="/images/logo-icon.svg" alt="Trash Bank" class="h-5 w-5 sm:h-6 sm:w-6" />
        <span class="hidden font-semibold sm:inline">Trash Bank</span>
    </div>

    {{-- Pill navigation (hidden on mobile) --}}
    <nav class="hidden items-center gap-1 rounded-full bg-base-200 p-1 lg:inline-flex">
        <a href="{{ route('dashboard') }}"
           class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                  {{ request()->routeIs('dashboard') ? 'bg-olive-700 text-white' : 'text-base-content/70 hover:bg-base-300/50' }}">
            Beranda
        </a>
        <a href="{{ route('tiket-sampah.index') }}"
           class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                  {{ request()->routeIs('tiket-sampah.*') ? 'bg-olive-700 text-white' : 'text-base-content/70 hover:bg-base-300/50' }}">
            Tiket Sampah
        </a>
        <a href="{{ route('tiket-poin.index') }}"
           class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                  {{ request()->routeIs('tiket-poin.*') ? 'bg-olive-700 text-white' : 'text-base-content/70 hover:bg-base-300/50' }}">
            Tiket Poin
        </a>
        <a href="{{ route('edukasi.index') }}"
           class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                  {{ request()->routeIs('edukasi.*') ? 'bg-olive-700 text-white' : 'text-base-content/70 hover:bg-base-300/50' }}">
            Edukasi
        </a>
        <a href="{{ route('riwayat.index') }}"
           class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                  {{ request()->routeIs('riwayat.*') ? 'bg-olive-700 text-white' : 'text-base-content/70 hover:bg-base-300/50' }}">
            Riwayat
        </a>
    </nav>

    <div class="flex items-center gap-2 sm:gap-3">
        <button class="btn btn-ghost btn-circle btn-sm">
            <span class="material-symbols-outlined">search</span>
        </button>
        <button class="btn btn-ghost btn-circle btn-sm">
            <span class="material-symbols-outlined">notifications</span>
        </button>
        <button class="btn btn-ghost btn-circle btn-sm">
            <span class="material-symbols-outlined">logout</span>
        </button>

        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="flex items-center gap-2 rounded-full px-2 py-1 hover:bg-base-200">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-olive-200 text-xs font-semibold">
                    {{ Str::of(session('user_name','User'))->explode(' ')->map(fn($w) => Str::substr($w, 0, 1))->take(2)->implode('') }}
                </div>
                <div class="text-left text-sm leading-tight">
                    <p class="font-medium">{{ session('user_name','User') }}</p>
                    <p class="text-xs text-base-content/50">{{ number_format(session('user_total_poin',0) ?? 0) }} poin</p>
                </div>
            </div>
            <ul tabindex="0" class="dropdown-content menu z-10 mt-2 w-40 rounded-box bg-base-100 p-2 shadow">
                <li><a href="{{ route('profil') }}">Profil</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Keluar</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>
