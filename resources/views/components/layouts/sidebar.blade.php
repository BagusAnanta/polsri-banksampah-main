{{--
    Sidebar icon-rail, dipakai di semua halaman lewat <x-layouts.app>.
    Simpan di: resources/views/components/layouts/sidebar.blade.php

    Menu bisa dibedakan per role dengan cek auth()->user()->role di sini.
--}}

<aside class="flex h-full w-16 flex-col items-center gap-4 bg-base-200/60 py-4">

    @php $role = auth()->user()->role ?? 'masyarakat'; @endphp

    <!-- dashboard
tiket-sampah.index
tiket-poin.index
edukasi.index
riwayat.index -->

    @if($role === 'masyarakat')
        <x-layouts.nav-icon route="dashboard" icon="home" label="dashboard" />
        <x-layouts.nav-icon route="tiket-sampah.index" icon="trash" label="Tiket Sampah" />
        <x-layouts.nav-icon route="tiket-poin.index" icon="gift" label="Tiket Poin" />
        <x-layouts.nav-icon route="edukasi.index" icon="book-open" label="Edukasi" />
        <x-layouts.nav-icon route="riwayat.index" icon="clock" label="Riwayat" />
    @elseif($role === 'admin_bank_sampah')
        <x-layouts.nav-icon route="admin.dashboard" icon="grid" label="Beranda" />
        <x-layouts.nav-icon route="admin.tiket.index" icon="trash" label="Semua Tiket" />
        <x-layouts.nav-icon route="admin.scan" icon="qr-code" label="Scan QR" />
    @elseif($role === 'super_admin')
        <x-layouts.nav-icon route="sa.dashboard" icon="grid" label="Beranda" />
        <x-layouts.nav-icon route="sa.masyarakat.index" icon="users" label="Masyarakat" />
        <x-layouts.nav-icon route="sa.bank-sampah.index" icon="building" label="Bank Sampah" />
        <x-layouts.nav-icon route="sa.edukasi.index" icon="book-open" label="Edukasi" />
        <x-layouts.nav-icon route="sa.pengaturan" icon="cog" label="Pengaturan" />
    @endif

    <div class="mt-auto flex flex-col gap-3">
        <x-layouts.nav-icon route="help" icon="question-mark-circle" label="Bantuan" />
        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-olive-200 text-xs font-semibold">
            {{ Str::of(session('user_name','User'))->explode(' ')->map(fn($w) => Str::substr($w, 0, 1))->take(2)->implode('') }}
        </div>
    </div>
</aside>
