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
                <h4 class="title">Orders List</h4>
            </div>
            {{-- <div class="right-content d-flex align-items-center gap-4">
                <a href="#">
                    <i class="fi fi-rr-plus"></i>
                </a>
            </div> --}}
        </div>
    </header>
@endsection
@section('content')
    <div class="dz-list notification-list">
        <div class="container pt-0">
            <div class="default-tab style-2 mt-1">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="home" role="tabpanel">
                        @if (session('success'))
                            <div class="alert alert-success solid alert-dismissible fade show">
                                <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor"
                                    stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                    class="me-2">
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
                        <ul class="featured-list">
                            @foreach ($orders as $order)
                                <li>
                                    <div class="dz-card list">
                                        <div class="dz-media">
                                            <img class="img-thumbnail img-cover" style="height: 130px"
                                                src="{{ Storage::url($order->product->image) }}"
                                                alt="{{ $order->product->name }}">
                                        </div>
                                        <div class="dz-content">
                                            <div class="dz-head">
                                                <h6 class="title">
                                                    ID Order: {{ $order->id }}
                                                </h6>
                                                <ul class="tag-list">
                                                    <li><a href="javascript:void(0);">tanggal order:
                                                            {{ $order->created_at }},</a>
                                                    </li>
                                                </ul>
                                                <ul class="tag-list">
                                                    <li><a href="javascript:void(0);">nama:
                                                            {{ $order->user->username }},</a>
                                                    </li>
                                                </ul>
                                                <ul class="tag-list">
                                                    <li><a href="javascript:void(0);">produk:
                                                            {{ $order->product->name }},</a></li>
                                                </ul>
                                                <ul class="tag-list">
                                                    <li><a href="javascript:void(0);">deskripsi:
                                                            {{ strlen($order->product->description) > 100 ? Str::limit($order->product->description, 100) : $order->product->description }},</a>
                                                    </li>
                                                </ul>
                                                <ul class="tag-list">
                                                    <li><a href="javascript:void(0);">qty: {{ $order->qty }}</a></li>
                                                </ul>
                                            </div>
                                            <ul class="dz-meta">
                                                <li class="dz-price flex-1" style="font-size: 16px">
                                                    Total {{ 'Rp. ' . number_format($order->total_price, 0, ',', ',') }}
                                                </li>
                                                <li>
                                                    <form action="{{ route('orders.update', $order->id) }}" method="POST">
                                                        @csrf
                                                        <select name="status" onchange="this.form.submit()"
                                                            class="form-select form-select-sm
                                                        {{ $order->status == 'pending' ? 'btn btn-warning' : '' }}
                                                        {{ $order->status == 'proses' ? 'btn btn-info' : '' }}
                                                        {{ $order->status == 'selesai' ? 'btn btn-success' : '' }}
                                                        {{ $order->status == 'batal' ? 'btn btn-danger' : '' }}">
                                                            <option value="pending"
                                                                {{ $order->status == 'pending' ? 'selected' : '' }}>Pending
                                                            </option>
                                                            <option value="proses"
                                                                {{ $order->status == 'proses' ? 'selected' : '' }}>Proses
                                                            </option>
                                                            <option value="selesai"
                                                                {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai
                                                            </option>
                                                            <option value="batal"
                                                                {{ $order->status == 'batal' ? 'selected' : '' }}>Batal
                                                            </option>
                                                        </select>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <hr />
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
