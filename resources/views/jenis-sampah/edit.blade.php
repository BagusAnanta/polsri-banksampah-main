@extends('layout-mobile.app')

@section('header')
    <header class="header header-fixed border-bottom">
        <div class="header-content">
            <div class="left-content">
                <a href="{{ route('jenis_sampahs.index') }}" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Ubah Jenis Sampah</h4>
            </div>
            <div class="right-content"></div>
        </div>
    </header>
@endsection

@section('content')
    <div class="edit-profile">
        <form action="{{ route('jenis_sampahs.update', $jenis_sampah->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <div class="mb-4">
                    <div class="mb-3">
                        <label class="form-label" for="nama">Jenis Sampah</label>
                        <div class="input-group input-mini input-sm">
                            <input type="text" id="nama" name="nama" class="form-control"
                                value="{{ $jenis_sampah->nama }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="gramasi">Satuan</label>
                        <div class="input-group input-mini input-sm">
                            <input type="text" id="gramasi" name="gramasi" class="form-control"
                                value="{{ $jenis_sampah->gramasi }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="harga">Harga</label>
                        <div class="input-group input-mini input-sm">
                            <input type="text" id="harga" name="harga" class="form-control"
                                value="{{ $jenis_sampah->harga }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="catatan">Catatan</label>
                        <div class="input-group input-mini input-sm">
                            <input type="text" id="catatan" name="catatan" class="form-control"
                                value="{{ $jenis_sampah->catatan }}">
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
