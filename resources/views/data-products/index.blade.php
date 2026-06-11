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
                <h4 class="title">Products</h4>
            </div>
            <div class="right-content d-flex align-items-center gap-4">
                <a href="{{ route('data-products.create') }}">
                    <i class="fi fi-rr-plus"></i>
                </a>
            </div>
        </div>
    </header>
@endsection
@section('content')
    <div class="dz-list notification-list">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <ul>
            @foreach ($products as $product)
                {{-- <li class="list-items pull_delete"
                    onclick="location.href='{{ route('data-products.show', $product->id) }}'">
                    <div class="media">
                        <div class="list-content">
                            <h5 class="title">{{ ucfirst($product->name) }}</h5>
                            <span class="date">{{ $product->description }}</span>
                        </div>
                    </div>
                </li> --}}
                <li onclick="location.href='{{ route('data-products.show', $product->id) }}'">
                    <div class="dz-card list">
                        <div class="dz-media">
                            <img class="img-thumbnail img-cover" style="height: 130px"
                                src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                        </div>
                        <div class="dz-content">
                            <div class="dz-head">
                                <h6 class="title">
                                    {{ ucfirst($product->name) }}
                                </h6>
                                <ul class="tag-list">
                                    <li><a
                                            href="javascript:void(0);">{{ strlen($product->description) > 100 ? Str::limit($product->description, 100) : $product->description }}</a>
                                    </li>
                                </ul>
                            </div>
                            <ul class="dz-meta">
                                <li class="dz-price mt-4 flex-1">{{ 'Rp. ' . number_format($product->price, 0, ',', ',') }}
                                </li>
                            </ul>
                        </div>
                    </div>
            @endforeach
        </ul>
    </div>
@endsection
