@extends('layout-mobile.app')

@section('header')
    <header class="header header-fixed border-bottom">
        <div class="header-content">
            <div class="left-content">
                <a href="{{ route('laporan-pengaduans.index') }}" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Tambah Laporan</h4>
            </div>
            <div class="right-content"></div>
        </div>
    </header>
@endsection

@section('content')
    <div class="edit-profile">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('laporan-pengaduans.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="box_sampah_id">Pilih Box Sampah</label>
                <select name="box_sampah_id" id="box_sampah_id" class="form-control" required>
                    <option value="">-- Pilih Box Sampah --</option>
                    @foreach ($boxSampahs as $box)
                        <option value="{{ $box->id }}">{{ $box->id_box }} ({{ $box->latitude }},
                            {{ $box->longitude }})</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="catatan">Catatan</label>
                <textarea name="catatan" id="catatan" class="form-control" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Kirim Laporan</button>
        </form>
    </div>

    {{-- <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, '', '{{ route('dashboard') }}');
        }
    </script> --}}
@endsection
