
<header class="flex items-center justify-between border-b border-base-300/40 px-4 py-3 sm:px-6 bg-[#E4CEA5]">

    @php $role = auth()->user()->getRoleNames()->first() ?? 'Masyarakat'; @endphp

    <div class="flex items-center gap-2 rounded-full px-2 py-1 bg-[#F1E3C7]">
        <img src="/images/logo-icon.svg" alt="Trash Bank" class="h-5 w-5 sm:h-6 sm:w-6" />
        <span class="hidden font-semibold sm:inline">Trash Bank</span>
    </div>

    {{-- Pill navigation (hidden on mobile) --}}

    @if($role === 'Masyarakat')
        <nav class="hidden items-center gap-1 rounded-full bg-base-200 p-1 lg:inline-flex bg-[#F1E3C7]">
            <a href="{{ route('dashboard') }}"
            class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                    {{ request()->routeIs('dashboard') ? 'bg-[#61440A] text-white' : 'text-base-content/70 hover:bg-[#E4CEA5]' }}">
                Beranda
            </a>
            <a href="{{ route('tiket-sampah.index') }}"
            class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                    {{ request()->routeIs('tiket-sampah.*') ? 'bg-[#61440A] text-white' : 'text-base-content/70 hover:bg-[#E4CEA5]' }}">
                Tiket Sampah
            </a>
            <a href="{{ route('tiket-poin.index') }}"
            class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                    {{ request()->routeIs('tiket-poin.*') ? 'bg-[#61440A] text-white' : 'text-base-content/70 hover:bg-[#E4CEA5]' }}">
                Tiket Poin
            </a>
            <a href="{{ route('edukasi-masyarakat.index') }}"
            class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                    {{ request()->routeIs('edukasi-masyarakat.*') ? 'bg-[#61440A] text-white' : 'text-base-content/70 hover:bg-[#E4CEA5]' }}">
                Edukasi
            </a>
            <a href="{{ route('riwayat.index') }}"
            class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                    {{ request()->routeIs('riwayat.*') ? 'bg-[#61440A] text-white' : 'text-base-content/70 hover:bg-[#E4CEA5]' }}">
                Riwayat
            </a>
        </nav>
        
    @elseif($role === 'Admin Bank Sampah')
        <nav class="hidden items-center gap-1 rounded-full bg-base-200 p-1 lg:inline-flex bg-[#F1E3C7]">
            <a href="{{ route('admin.dashboard') }}"
            class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                    {{ request()->routeIs('admin.dashboard') ? 'bg-[#61440A] text-white' : 'text-base-content/70 hover:bg-[#E4CEA5]' }}">
                Beranda
            </a>
            <a href="{{ route('admin.tiket-setor.index') }}"
            class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                    {{ request()->routeIs('admin.tiket-setor.*') ? 'bg-[#61440A] text-white' : 'text-base-content/70 hover:bg-[#E4CEA5]' }}">
                Tiket Sampah
            </a>
            <a href="{{ route('admin.tiket-poin.index') }}"
            class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                    {{ request()->routeIs('admin.tiket-poin.*') ? 'bg-[#61440A] text-white' : 'text-base-content/70 hover:bg-[#E4CEA5]' }}">
                Tiket Poin
            </a>
            <a href="{{ route('admin.scan') }}"
            class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                    {{ request()->routeIs('admin.scan.*') ? 'bg-[#61440A] text-white' : 'text-base-content/70 hover:bg-[#E4CEA5]' }}">
                Scan QR
            </a>
        </nav>

    @elseif($role === 'Super Admin')
        <nav class="hidden items-center gap-1 rounded-full bg-base-200 p-1 lg:inline-flex bg-[#F1E3C7]">
            <a href="{{ route('sa.dashboard') }}"
            class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                    {{ request()->routeIs('sa.dashboard') ? 'bg-[#61440A] text-white' : 'text-base-content/70 hover:bg-[#E4CEA5]' }}">
                Beranda
            </a>
            <a href="{{ route('sa.masyarakat.index') }}"
            class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                    {{ request()->routeIs('sa.masyarakat.*') ? 'bg-[#61440A] text-white' : 'text-base-content/70 hover:bg-[#E4CEA5]' }}">
                Masyarakat
            </a>
            <a href="{{ route('sa.bank-sampah.index') }}"
            class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                    {{ request()->routeIs('sa.bank-sampah.*') ? 'bg-[#61440A] text-white' : 'text-base-content/70 hover:bg-[#E4CEA5]' }}">
                Bank Sampah
            </a>
            <a href="{{ route('sa.edukasi-superadmin.index') }}"
            class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                    {{ request()->routeIs('sa.edukasi-superadmin.*') ? 'bg-[#61440A] text-white' : 'text-base-content/70 hover:bg-[#E4CEA5]' }}">
                Edukasi
            </a>
            <a href="{{ route('sa.pengaturan.index') }}"
            class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                    {{ request()->routeIs('sa.pengaturan.*') ? 'bg-[#61440A] text-white' : 'text-base-content/70 hover:bg-[#E4CEA5]' }}">
                Pengaturan
            </a>
        </nav>
    @endif

    <div class="flex items-center gap-2 sm:gap-3">
        
        <div class="dropdown dropdown-end">
            {{-- Bell icon trigger with unread count badge --}}
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                <div class="indicator">
                    <span class="material-symbols-outlined">notifications</span>
                    @if($unreadCount > 0)
                        <span class="badge badge-sm badge-error indicator-item rounded-full bg-[#61440A] text-white">
                            {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                        </span>
                    @endif
                </div>
            </div>

            {{-- Dropdown panel --}}
            <div tabindex="0" class="dropdown-content z-[1] mt-3 w-80 sm:w-96 bg-base-100 border border-base-300 rounded-box shadow-xl">

                {{-- Header --}}
                <div class="flex items-center justify-between px-4 py-3 border-b border-base-300">
                    <h3 class="font-semibold text-base">Notifikasi</h3>

                    <!-- @if($unreadCount > 0)
                        <form method="POST" action="{{ route('notifications.read-all') }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-ghost btn-xs text-primary">
                                Mark all read
                            </button>
                        </form>
                    @endif -->
                </div>

                {{-- Scrollable message list --}}
                <div class="max-h-96 overflow-y-auto">
                    @forelse($notifications as $notification)
                        <a
                            class="flex gap-3 px-4 py-3 border-b border-base-200 last:border-b-0 hover:bg-base-200/70 transition-colors {{ $notification->read_at ? '' : 'bg-primary/5' }}"
                        >
                            {{-- Unread dot indicator --}}
                            <div class="pt-1.5 shrink-0">
                                <span class="inline-block w-2 h-2 rounded-full {{ $notification->read_at ? 'bg-transparent' : 'bg-primary' }}"></span>
                            </div>

                            <div class="flex flex-col gap-0.5 min-w-0">
                                <span class="font-medium text-sm truncate">
                                    {{ $notification->data['title'] ?? 'Notification' }}
                                </span>
                                <span class="text-xs text-base-content/70 line-clamp-2">
                                    {{ $notification->data['message'] ?? '' }}
                                </span>
                                <span class="text-xs text-base-content/50 mt-0.5">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </a>
                    @empty
                        <div class="flex flex-col items-center justify-center gap-2 py-10 text-base-content/50">
                            <span class="material-symbols-outlined text-3xl">notifications_off</span>
                            <span class="text-sm">Belum ada notifikasi.</span>
                        </div>
                    @endforelse
                </div>

                <!-- {{-- Optional footer: link to full notifications page --}}
                @if($notifications->isNotEmpty())
                    <div class="border-t border-base-300 p-2">
                        <a href="{{ route('notifications.index') }}" class="btn btn-ghost btn-sm w-full">
                            Lihat semua notifikasi
                        </a>
                    </div>
                @endif -->
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
             <button type="submit" class="btn btn-ghost btn-circle btn-sm">
                <span class="material-symbols-outlined">logout</span>
             </button>
        </form>

        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="flex items-center gap-2 rounded-full px-2 py-1 hover:bg-[#E4CEA5] bg-[#F1E3C7]">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-[#A3A85C] text-xs font-semibold">
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
