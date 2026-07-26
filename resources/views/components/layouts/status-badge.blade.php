{{--
    Komponen: Status Badge (Menunggu/Selesai/Ditolak/Dibatalkan)
    Cara pakai:
        <x-status-badge status="menunggu" />

    Simpan di: resources/views/components/status-badge.blade.php
--}}

@props(['status'])

@php
    $map = [
        'menunggu'  => ['label' => 'Menunggu',  'class' => 'bg-amber-100 text-amber-600'],
        'selesai'   => ['label' => 'Selesai',   'class' => 'bg-green-100 text-green-600'],
        'ditolak'   => ['label' => 'Ditolak',   'class' => 'bg-red-100 text-red-500'],
        'dibatalkan'=> ['label' => 'Dibatalkan','class' => 'bg-base-300 text-base-content/60'],
    ];
    $badge = $map[$status] ?? ['label' => ucfirst($status), 'class' => 'bg-base-300 text-base-content/60'];
@endphp

<span class="badge border-none px-3 py-3 text-xs font-medium {{ $badge['class'] }}">
    {{ $badge['label'] }}
</span>
