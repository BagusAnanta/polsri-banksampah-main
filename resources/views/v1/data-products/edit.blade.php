@extends('layout-mobile.app')

@section('header')
    <header class="header header-fixed border-bottom">
        <div class="header-content">
            <div class="left-content">
                <a href="{{ route('data-products.index') }}" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Ubah Product</h4>
            </div>
            <div class="right-content"></div>
        </div>
    </header>
@endsection

@section('content')
    <div class="edit-profile">
        <form action="{{ route('data-products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <div class="mb-4">
                    <div class="mb-3">
                        <label class="form-label" for="name">Nama Product</label>
                        <div class="input-group input-mini input-sm">
                            <input type="text" id="name" name="name" class="form-control"
                                value="{{ $product->name }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="description">Deskripsi</label>
                        <div class="input-group input-mini input-sm">
                            <input type="text" id="description" name="description" class="form-control"
                                value="{{ $product->description }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="price">Harga</label>
                        <div class="input-group input-mini input-sm">
                            <input type="text" id="price" name="price" class="form-control"
                                value="{{ floor($product->price) }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="image">Gambar</label>
                        <div class="input-group">
                            <input type="file" id="image" name="image" class="form-control">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="img-thumbnail mt-2">
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
