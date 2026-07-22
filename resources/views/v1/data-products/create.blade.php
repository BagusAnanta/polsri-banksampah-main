@extends('layout-mobile.app')

@section('header')
    <header class="header header-fixed border-bottom">
        <div class="header-content">
            <div class="left-content">
                <a href="{{ route('users.index') }}" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Tambah Product</h4>
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
        <form action="{{ route('data-products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <div class="mb-3">
                    <label class="form-label" for="name">Nama</label>
                    <div class="input-group input-mini input-sm">
                        <input type="text" id="name" name="name" class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="price">Harga</label>
                    <div class="input-group input-mini input-sm">
                        <input type="number" id="price" name="price" class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="description">Deskripsi</label>
                    <div class="input-group input-mini input-sm">
                        <input type="text" id="description" name="description" class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="image">Gambar</label>
                    <div class="input-group">
                        <input type="file" id="image" name="image" class="form-control">
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <button type="submit" style="width: 100%" class="btn btn-success">SIMPAN</button>
            </div>
        </form>
    </div>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, '', '{{ route('dashboard') }}');
        }
    </script>
@endsection
