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
            <h4 class="title">Daftar Pengguna</h4>
        </div>
        <div class="right-content d-flex align-items-center gap-4">
            <a href="{{route('users.create')}}">
                <i class="fi fi-rr-plus"></i>
            </a>
        </div>
    </div>
</header>
@endsection
@section('content')
<div class="dz-list notification-list">
    <ul>
        @foreach ($users as $user)
        <li class="list-items pull_delete" onclick="location.href='{{route('users.show', $user->id)}}'">
            <div class="media">
                <div class="media-60 m-r10">
                    <img src="{{ asset('ui/images/profile/'.($user->avatar ?? 'user.png')) }}" alt="">
                </div>
                <div class="list-content">
                    <h5 class="title">{{ucfirst($user->name)}}</h5>
                    <span class="date">{{ $user->getRoleNames()->first() ?? 'No role' }}</span>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>
@endsection