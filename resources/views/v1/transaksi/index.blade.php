@extends('layout-mobile.app')
@section('header')
    <header class="header header-fixed">
        <div class="header-content">
            <div class="left-content">
                <a href="{{ route('dashboard') }}" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Transaksi</h4>
            </div>
            <div class="right-content d-flex align-items-center gap-4">
            </div>
        </div>
    </header>
@endsection
@section('content')
    <div class="dz-list notification-list">

        <!-- Main Content Start -->
        <main class="page-content bg-white p-b60">
            <div class="container">

                <!-- Flash message -->
                @if (session('success'))
                    <div class="alert alert-success solid alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2"
                            fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                            <span><i class="icon feather icon-x"></i></span>
                        </button>
                    </div>
                @endif

                @error('kredit')
                    <div class="alert alert-danger solid alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2"
                            fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                            <span><i class="icon feather icon-x"></i></span>
                        </button>
                    </div>
                @enderror
                @error('tabungan_id')
                    <div class="alert alert-danger solid alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2"
                            fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                            <span><i class="icon feather icon-x"></i></span>
                        </button>
                    </div>
                @enderror
                <!-- Form Input Kredit -->
                <form class="d-flex align-items-center gap-3" action="{{ route('transaksi.updateKredit') }}" method="POST">
                    @csrf
                    @if ($firstTabungan)
                        <input type="hidden" name="tabungan_id" value="{{ $firstTabungan->id }}">
                    @endif
                    <div class="mb-3" style="width: 70%">
                        <label for="kredit" class="form-label">Nominal Kredit</label>
                        @if ($kreditNasabah)
                            <input type="number" name="kredit" id="kredit" class="form-control"
                                {{ $kreditNasabah->kredit > 0 && $kreditNasabah->status === 'pending' ? 'disabled' : '' }}
                                required min="0">
                        @else
                            <input type="number" name="kredit" id="kredit" class="form-control" disabled required
                                min="0">
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary mt-2 btn-simpan"
                        @if ($kreditNasabah && $kreditNasabah->kredit > 0 && $kreditNasabah->status === 'pending') disabled @endif style="width: 30%">Simpan</button>
                </form>
                <div class="d-flex align-items-center gap-3 mt-5" style="width: 100% !important">
                    <form action="{{ route('download-nota-pdf') }}" method="GET" class="mt-3" style="width: 100%">
                        @csrf
                        @if ($firstTabungan)
                            <input type="hidden" name="tabungan_id" value="{{ $firstTabungan->id }}">
                        @else
                        @endif
                        <button type="submit" class="btn btn-outline-info" style="width: 100%">Cetak
                            Nota</button>
                    </form>
                    <form action="{{ route('download-tabungan-pdf') }}" method="GET" class="mt-3"
                        style="width: 100%">
                        @csrf
                        @if ($firstTabungan)
                            <input type="hidden" name="tabungan_id" value="{{ $firstTabungan->id }}">
                        @else
                        @endif
                        <button type="submit" class="btn btn-outline-primary" style="width: 100%">
                            Cetak Tabungan
                        </button>
                    </form>
                </div>

                <!-- Tabel Tabungan -->
                <h5 class="mt-5">Data Tabungan</h5>
                @if ($lastTabungan != null && $lastTabungan->status === 'pending')
                    <div class="alert alert-warning solid alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2"
                            fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                        Penyetoran menunggu approved dari admin.
                    </div>
                @elseif ($lastTabungan != null && $lastTabungan->status === 'gagal')
                    <div class="alert alert-danger solid alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2"
                            fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                        Penyetoran gagal, silahkan setor ulang dan perhatikan sampah yang disetor.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                            <span><i class="icon feather icon-x"></i></span>
                        </button>
                    </div>
                @endif
                @if ($kreditNasabah->kredit > 0 && $kreditNasabah->status === 'pending')
                    <div class="alert alert-warning solid alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2"
                            fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                        Kredit menunggu persetujuan Admin.
                    </div>
                @endif
                <table id="myTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Debit</th>
                            <th>Kredit</th>
                            <th>Sisa Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($tabungan->count() > 0)
                            @php
                                $nomor = ($tabungan->currentPage() - 1) * $tabungan->perPage() + 1;
                            @endphp
                            @foreach ($tabungan as $item)
                                <tr>
                                    <td>{{ $nomor++ }}</td>
                                    <td>{{ formatDateIndo($item->tanggal) }}</td>
                                    @if ($item->kredit > 0)
                                        <td></td>
                                        <td>{{ 'Rp. ' . number_format($item->kredit, 0, ',', '.') }}</td>
                                    @else
                                        <td>{{ 'Rp. ' . number_format($item->debit, 0, ',', '.') }}</td>
                                        <td></td>
                                    @endif
                                    <td>{{ 'Rp. ' . number_format($item->sisa_saldo, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">
                                    Tidak ada data.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                @if ($tabungan->count() > 0)
                    <div class="d-flex">
                        {{ $tabungan->links() }}
                    </div>
                @endif
            </div>
            {{-- @endif --}}

        </main>
        <!-- Main Content End -->
    </div>

    {{-- <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, '', '{{ route('dashboard') }}');
        }
    </script> --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', () => {
            const deleteButton = document.querySelector('.btn-simpan');

            if (deleteButton) {
                deleteButton.addEventListener('click', () => {
                    history.pushState(null, '', '{{ route('dashboard') }}');
                });
            }
        });
    </script> --}}

@endsection
