@extends('layout-mobile.app')

@section('header')
    <header class="header header-fixed border-bottom">
        <div class="header-content">
            <div class="left-content">
                <a href="{{ route('users.show', $user->id) }}" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Ubah Profil</h4>
            </div>
            <div class="right-content"></div>
        </div>
    </header>
@endsection

@section('content')
    <div class="edit-profile">
        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @method('patch')
            @csrf
            <div class="profile-image">
                <div class="avatar-upload mt-3">
                    <div class="avatar-preview">
                        <div id="imagePreview"
                            style="background-image: url({{ asset('ui/images/profile/' . ($user->avatar ?? 'user.png')) }});">
                        </div>
                        <div class="change-btn">
                            <input type='file' class="form-control d-none" name="avatar" id="imageUpload"
                                accept=".png, .jpg, .jpeg">
                            <label for="imageUpload">
                                <i class="fi fi-rr-pencil"></i>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label" for="name">Nama Lengkap</label>
                <div class="input-group input-mini input-sm">
                    <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}">
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label" for="address">Nama Pengguna</label>
                <div class="input-group input-mini input-sm">
                    <input type="text" id="username" name="username" class="form-control" value="{{ $user->username }}">
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label" for="no_rekening">No Rekening</label>
                <div class="input-group input-mini input-sm">
                    <input type="tel" id="no_rekening" name="no_rekening" class="form-control"
                        value="{{ $user->no_rekening }}">
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label" for="bank">Nama Bank</label>
                <div class="input-group input-mini input-sm">
                    <input type="tel" id="bank" name="bank" class="form-control" value="{{ $user->bank }}">
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label" for="phone">Nomor Telepon</label>
                <div class="input-group input-mini input-sm">
                    <input type="tel" id="phone" name="phone" class="form-control" value="{{ $user->phone }}">
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label" for="alamat">Alamat</label>
                <div class="input-group input-mini input-sm">
                    <input type="tel" id="alamat" name="alamat" class="form-control" value="{{ $user->address }}">
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label" for="email">Email</label>
                <div class="input-group input-mini input-sm">
                    <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}">
                </div>
            </div>
            <div class="mb-4">
                <button type="submit" style="width: 100%" class="btn btn-success">UBAH PROFIL</button>
            </div>
        </form>
    </div>
@endsection
