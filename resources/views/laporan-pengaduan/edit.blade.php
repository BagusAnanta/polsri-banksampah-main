@extends('layout-mobile.app')

@section('header')
    <header class="header header-fixed border-bottom">
        <div class="header-content">
            <div class="left-content">
                <a href="{{ route('laporan-pengaduans.indexNasabah') }}" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Ubah Laporan</h4>
            </div>
            <div class="right-content"></div>
        </div>
    </header>
@endsection

@section('content')
    <div class="edit-profile">
        <form action="{{ route('laporan-pengaduans.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <div class="mb-4">
                    <div class="mb-3">
                        <label for="box_sampah_id">Pilih Box Sampah</label>
                        <select name="box_sampah_id" id="box_sampah_id" class="form-control" required>
                            <option value="">-- Pilih Box Sampah --</option>
                            @foreach ($boxSampahs as $box)
                                <option value="{{ $box->id }}"
                                    {{ $laporan->boxSampah->id == $box->id ? 'selected' : '' }}>{{ $box->id_box }}
                                    ({{ $box->latitude }},
                                    {{ $box->longitude }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="catatan">Catatan</label>
                        <div class="input-group input-mini input-sm">
                            <input type="text" id="catatan" name="catatan" class="form-control"
                                value="{{ $laporan->catatan }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <button type="submit" style="width: 100%" class="btn btn-success">UBAH</button>
            </div>
        </form>
    </div>
@endsection
