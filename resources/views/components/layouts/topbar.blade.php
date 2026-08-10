
<header class="flex items-center justify-between border-b border-base-300/40 px-4 py-3 sm:px-6">

    @php $role = auth()->user()->getRoleNames()->first() ?? 'Masyarakat'; @endphp

    <div class="flex items-center gap-2">
        <img src="/images/logo-icon.svg" alt="Trash Bank" class="h-5 w-5 sm:h-6 sm:w-6" />
        <span class="hidden font-semibold sm:inline">Trash Bank</span>
    </div>

    {{-- Pill navigation (hidden on mobile) --}}

    @if($role === 'Masyarakat')
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
            <a href="{{ route('edukasi-masyarakat.index') }}"
            class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                    {{ request()->routeIs('edukasi-masyarakat.*') ? 'bg-olive-700 text-white' : 'text-base-content/70 hover:bg-base-300/50' }}">
                Edukasi
            </a>
            <a href="{{ route('riwayat.index') }}"
            class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                    {{ request()->routeIs('riwayat.*') ? 'bg-olive-700 text-white' : 'text-base-content/70 hover:bg-base-300/50' }}">
                Riwayat
            </a>
        </nav>
        
    @elseif($role === 'Admin Bank Sampah')
        <nav class="hidden items-center gap-1 rounded-full bg-base-200 p-1 lg:inline-flex">
            <a href="{{ route('admin.dashboard') }}"
            class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                    {{ request()->routeIs('admin.dashboard') ? 'bg-olive-700 text-white' : 'text-base-content/70 hover:bg-base-300/50' }}">
                Beranda
            </a>
            <a href="{{ route('admin.tiket-setor.index') }}"
            class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                    {{ request()->routeIs('admin.tiket-setor.*') ? 'bg-olive-700 text-white' : 'text-base-content/70 hover:bg-base-300/50' }}">
                Tiket Sampah
            </a>
            <a href="{{ route('admin.tiket-poin.index') }}"
            class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                    {{ request()->routeIs('admin.tiket-poin.*') ? 'bg-olive-700 text-white' : 'text-base-content/70 hover:bg-base-300/50' }}">
                Tiket Poin
            </a>
            <a href="{{ route('admin.scan') }}"
            class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                    {{ request()->routeIs('admin.scan.*') ? 'bg-olive-700 text-white' : 'text-base-content/70 hover:bg-base-300/50' }}">
                Scan QR
            </a>
        </nav>

    @elseif($role === 'Super Admin')
        <nav class="hidden items-center gap-1 rounded-full bg-base-200 p-1 lg:inline-flex">
            <a href="{{ route('sa.dashboard') }}"
            class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                    {{ request()->routeIs('sa.dashboard') ? 'bg-olive-700 text-white' : 'text-base-content/70 hover:bg-base-300/50' }}">
                Beranda
            </a>
            <a href="{{ route('sa.masyarakat.index') }}"
            class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                    {{ request()->routeIs('sa.masyarakat.*') ? 'bg-olive-700 text-white' : 'text-base-content/70 hover:bg-base-300/50' }}">
                Masyarakat
            </a>
            <a href="{{ route('sa.bank-sampah.index') }}"
            class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                    {{ request()->routeIs('sa.bank-sampah.*') ? 'bg-olive-700 text-white' : 'text-base-content/70 hover:bg-base-300/50' }}">
                Bank Sampah
            </a>
            <a href="{{ route('sa.edukasi-superadmin.index') }}"
            class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                    {{ request()->routeIs('sa.edukasi-superadmin.*') ? 'bg-olive-700 text-white' : 'text-base-content/70 hover:bg-base-300/50' }}">
                Edukasi
            </a>
            <a href="{{ route('sa.pengaturan.index') }}"
            class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                    {{ request()->routeIs('sa.pengaturan.*') ? 'bg-olive-700 text-white' : 'text-base-content/70 hover:bg-base-300/50' }}">
                Pengaturan
            </a>
        </nav>
    @endif


    <div class="flex items-center gap-2 sm:gap-3">
        <button class="btn btn-ghost btn-circle btn-sm">
            <span class="material-symbols-outlined">search</span>
        </button>
        
        <button class="btn btn-ghost btn-circle btn-sm">
            <span class="material-symbols-outlined">notifications</span>
        </button>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
             <button type="submit" class="btn btn-ghost btn-circle btn-sm">
                <span class="material-symbols-outlined">logout</span>
             </button>
        </form>

        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="flex items-center gap-2 rounded-full px-2 py-1 hover:bg-base-200">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-olive-200 text-xs font-semibold">
                    {{ Str::of(auth()->user()->name)->explode(' ')->map(fn($w) => Str::substr($w, 0, 1))->take(2)->implode('') }}
                </div>

                @if($role === 'Masyarakat')
                <div class="text-left text-sm leading-tight">
                    <p class="font-medium">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-base-content/50">{{ number_format(auth()->user()->masyarakat->poin ?? 0) }} poin</p>
                </div>
                @elseif($role === 'Admin Bank Sampah')
                <div class="text-left text-sm leading-tight">
                    <p class="font-medium">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-base-content/50">Admin Bank Sampah</p>
                </div>
                @elseif($role === 'Super Admin')
                <div class="text-left text-sm leading-tight">
                    <p class="font-medium">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-base-content/50">Super Admin</p>
                </div>
                @endif

            </div>

            <ul tabindex="0" class="dropdown-content menu z-10 mt-2 w-40 rounded-box bg-base-100 p-2 shadow">
                <li>
                    @if($role === 'Masyarakat')
                        <a href="{{ route('profile-masyarakat', auth()->user()->masyarakat->masyarakat_id) }}">Profil</a>
                    @elseif($role === 'Admin Bank Sampah')
                        <a href="{{ route('admin.profile-banksampah', auth()->user()->admin_banksampah->banksampah_id) }}">Profil</a>
                    @endif
                </li>
                <li>
                    <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" onclick="document.getElementById('logout-form').submit(); return false;">Keluar</a>
                </li>
            </ul>
        </div>
    </div>
</header>
