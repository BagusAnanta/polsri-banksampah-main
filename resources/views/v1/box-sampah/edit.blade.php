@extends('layout-mobile.app')

@section('header')
    <header class="header header-fixed border-bottom">
        <div class="header-content">
            <div class="left-content">
                <a href="{{ route('box-sampahs.index') }}" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Ubah Box Sampah</h4>
            </div>
            <div class="right-content"></div>
        </div>
    </header>
@endsection

@section('content')
    <div class="edit-profile">
        <form action="{{ route('box-sampahs.update', $boxSampah->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <div class="mb-4">
                    <div class="mb-3">
                        <label class="form-label" for="id_box">ID Box</label>
                        <div class="input-group input-mini input-sm">
                            <input type="text" id="id_box" name="id_box" class="form-control"
                                value="{{ $boxSampah->id_box }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="latitude">Latitude</label>
                        <div class="input-group input-mini input-sm">
                            <input type="text" id="latitude" name="latitude" class="form-control"
                                value="{{ $boxSampah->latitude }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="longitude">Longitude</label>
                        <div class="input-group input-mini input-sm">
                            <input type="text" id="longitude" name="longitude" class="form-control"
                                value="{{ $boxSampah->longitude }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="description">Description</label>
                        <div class="input-group input-mini input-sm">
                            <input type="text" id="description" name="description" class="form-control"
                                value="{{ $boxSampah->description }}">
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
