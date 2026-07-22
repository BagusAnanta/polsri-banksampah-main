@extends('layout-mobile.app')

@section('header')
<header class="header header-fixed border-bottom">
    <div class="header-content">
        <div class="left-content">
            <a href="{{route('departements.index')}}" class="back-btn">
                <i class="feather icon-arrow-left"></i>
            </a>
        </div>
        <div class="mid-content">
            <h4 class="title">Ubah Role</h4>
        </div>
        <div class="right-content"></div>
    </div>
</header>
@endsection

@section('content')
<div class="edit-profile">
<form action="{{ route('departements.update', $departement->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-4">
        <label class="form-label" for="name">Role</label>
        <div class="input-group input-mini input-sm">
            <input type="text" id="name" name="name" class="form-control" value="{{$departement->name}}">
        </div>
    </div>
    <div class="mb-4">
        <button type="submit" style="width: 100%" class="btn btn-success">UBAH</button>
    </div>
    </form>
</div>
@endsection

