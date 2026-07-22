@extends('layout-mobile.app')

@section('header')
<header class="header header-fixed border-bottom">
    <div class="header-content">
        <div class="left-content">
            <a href="{{route('users.index')}}" class="back-btn">
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
@if (!$jenis_sampah->isEmpty())
<form action="{{route('bank_sampahs.store')}}" method="post">
@csrf
<div class="accordion dz-accordion" id="accordionExample">
    @foreach ($jenis_sampah as $key => $item)
    <div class="accordion-item">
        <div class="accordion-header acco-select" id="heading{{$key}}">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}">
                {{-- <span class="dz-icon">
                    <i class="fi fi-rr-plus"></i>
                </span> --}}
                <span class="acco-title">{{$item->nama}}</span>
                <span class="checkmark"></span>
            </button>
        </div>
        <div id="collapse{{$key}}" class="accordion-collapse collapse" aria-labelledby="heading{{$key}}" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <div class="mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="qty[{{ $item->id }}]" class="form-control" autocomplete="off" placeholder="0" value="{{$item->getQtyAttribute($item->id, Auth::user()->id)}}">
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
<button type="submit" class="btn btn-thin btn-primary rounded-xl btn-block">SIMPAN</button>
</form>
@endif
@endsection

