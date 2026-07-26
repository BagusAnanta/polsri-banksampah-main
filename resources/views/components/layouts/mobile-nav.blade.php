@php $role = auth()->user()->role ?? 'masyarakat'; @endphp

<!-- dashboard
tiket-sampah.index
tiket-poin.index
edukasi.index
riwayat.index -->

<nav class="flex w-full items-center justify-around px-2 py-2">
    @if($role === 'masyarakat')
        <x-layouts.mobile-nav-item route="dashboard" icon="home" label="Beranda" />
        <x-layouts.mobile-nav-item route="tiket-sampah.index" icon="trash" label="Setor" />
        <x-layouts.mobile-nav-item route="tiket-poin.index" icon="gift" label="Tukar" />
        <x-layouts.mobile-nav-item route="edukasi.index" icon="book-open" label="Edukasi" />
        <x-layouts.mobile-nav-item route="riwayat.index" icon="clock" label="Riwayat" />
    @elseif($role === 'admin_bank_sampah')
        <x-layouts.mobile-nav-item route="admin.dashboard" icon="grid" label="Beranda" />
        <x-layouts.mobile-nav-item route="admin.tiket.index" icon="trash" label="Tiket" />
        <x-layouts.mobile-nav-item route="admin.scan" icon="qr-code" label="Scan" />
    @elseif($role === 'super_admin')
        <x-layouts.mobile-nav-item route="sa.dashboard" icon="grid" label="Beranda" />
        <x-layouts.mobile-nav-item route="sa.masyarakat.index" icon="users" label="Warga" />
        <x-layouts.mobile-nav-item route="sa.bank-sampah.index" icon="building" label="Bank" />
        <x-layouts.mobile-nav-item route="sa.edukasi.index" icon="book-open" label="Edukasi" />
        <x-layouts.mobile-nav-item route="sa.pengaturan" icon="cog" label="Set" />
    @endif
</nav>
