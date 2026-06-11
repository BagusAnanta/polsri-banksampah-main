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
                <h4 class="title">Setor</h4>
            </div>
            <div class="right-content"></div>
        </div>
    </header>
@endsection

@section('content')
    @error('generalError')
        <div class="alert alert-danger solid alert-dismissible fade show">
            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"
                stroke-linecap="round" stroke-linejoin="round" class="me-2">
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
    @if (!$jenis_sampah->isEmpty())
        <form action="{{ route('bank_sampahs.store') }}" method="post">
            @csrf
            <div class="accordion dz-accordion" id="accordionExample">
                <div class="alert alert-info solid alert-dismissible fade show py-3 d-flex align-items-center mb-2">
                    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    <span class="font-18 fw-semibold"> User Id: {{ Auth::user()->user_code }}</span>
                </div>
                @foreach ($jenis_sampah as $key => $item)
                    <div class="dz-add-box mb-2">
                        <span>{{ $item->nama }}</span>
                        <div class="mb-2 input-group input-group-icon" style="width: 40%">
                            <span class="input-group-text">
                                <input class="form-control" name="qty[{{ $item->id }}]" type="number" placeholder="0"
                                    value="{{ $item->getQtyAttribute($item->id, Auth::user()->id) }}">
                                <span>&nbsp;gram</span>
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-thin btn-primary rounded-xl btn-block">SIMPAN</button>
        </form>
    @endif
@endsection
