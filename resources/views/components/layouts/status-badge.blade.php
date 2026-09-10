{{--
    Komponen: Status Badge (Menunggu/Selesai/Ditolak/Dibatalkan)
    Cara pakai:
        <x-status-badge status="menunggu" />

    Simpan di: resources/views/components/status-badge.blade.php
--}}

@props(['status'])

@php
    $map = [
        'Disetujui' => ['label' => 'Disetujui', 'class' => 'bg-[#A3A85C] text-white'],
        'menunggu'  => ['label' => 'Menunggu',  'class' => 'bg-amber-100 text-amber-600'],
        'selesai'   => ['label' => 'Selesai',   'class' => 'bg-green-100 text-green-600'],
        'ditolak'   => ['label' => 'Ditolak',   'class' => 'bg-red-100 text-red-500'],
        'dibatalkan'=> ['label' => 'Dibatalkan','class' => 'bg-red-100 text-red-600'],
    ];
    $badge = $map[$status] ?? ['label' => ucfirst($status), 'class' => 'bg-base-300 text-base-content/60'];
@endphp

<span class="rounded-full px-2.5 py-0.5 text-xs font-medium whitespace-nowrap {{ $badge['class'] }}">
    {{ $badge['label'] }}
</span>
