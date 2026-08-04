@php $role = auth()->user()->getRoleNames()->first() ?? 'Masyarakat'; @endphp

<nav class="flex w-full items-center justify-around px-2 py-2">
    @if($role === 'Masyarakat')
        <x-layouts.mobile-nav-item route="dashboard" icon="home" label="Beranda" />
        <x-layouts.mobile-nav-item route="tiket-sampah.index" icon="trash" label="Setor" />
        <x-layouts.mobile-nav-item route="tiket-poin.index" icon="gift" label="Tukar" />
        <x-layouts.mobile-nav-item route="edukasi-masyarakat.index" icon="book-open" label="Edukasi" />
        <x-layouts.mobile-nav-item route="riwayat.index" icon="clock" label="Riwayat" />
    @elseif($role === 'Admin Bank Sampah')
        <x-layouts.mobile-nav-item route="admin.dashboard" icon="grid" label="Beranda" />
        <x-layouts.mobile-nav-item route="admin.tiket-setor.index" icon="trash" label="Tiket Sampah" />
        <x-layouts.mobile-nav-item route="admin.tiket-poin.index" icon="gift" label="Tiket Poin" />
        <x-layouts.mobile-nav-item route="admin.scan" icon="qr-code" label="Scan" />
    @elseif($role === 'Super Admin')
        <x-layouts.mobile-nav-item route="sa.dashboard" icon="grid" label="Beranda" />
        <x-layouts.mobile-nav-item route="sa.masyarakat.index" icon="users" label="Warga" />
        <x-layouts.mobile-nav-item route="sa.bank-sampah.index" icon="building" label="Bank" />
        <x-layouts.mobile-nav-item route="sa.edukasi-superadmin.index" icon="book-open" label="Edukasi" />
        <x-layouts.mobile-nav-item route="sa.pengaturan.index" icon="cog" label="Set" />
    @endif
</nav>
