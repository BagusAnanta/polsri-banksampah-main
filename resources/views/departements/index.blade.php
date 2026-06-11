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
            <h4 class="title">Role</h4>
        </div>
        <div class="right-content d-flex align-items-center gap-4">
            <a href="{{route('departements.create')}}">
                <i class="fi fi-rr-plus"></i>
            </a>
        </div>
    </div>
</header>
@endsection
@section('content')
<div class="dz-list notification-list">
    <ul>
        @foreach ($departements as $departement)
        <li class="list-items pull_delete" onclick="location.href='{{route('departements.show', $departement->id)}}'">
            <div class="media">
                {{-- <div class="media-60 m-r10">
                    <img src="{{ asset('ui/images/profile/'.($departement->avatar ?? 'departement.png')) }}" alt="">
                </div> --}}
                <div class="list-content">
                    <h5 class="title">{{ucfirst($departement->name)}}</h5>
                    {{-- <span class="date">{{$departement->getRoleNames()[0]}}</span> --}}
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>
@endsection