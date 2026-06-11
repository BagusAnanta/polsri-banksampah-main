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
            <h4 class="title">Create Role</h4>
        </div>
        <div class="right-content"></div>
    </div>
</header>
@endsection

@section('content')
<div class="edit-profile">
<form action="{{ route('departements.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-4">
        <label class="form-label" for="name">Name</label>
        <div class="input-group input-mini input-sm">
            <input type="text" id="name" name="name" class="form-control">
        </div>
    </div>
    {{-- <div class="mb-4">
        <label class="form-label" for="address">Permission</label>
        <div class="input-group input-mini input-sm">
            <small>Select All</small>
            <input type="checkbox" id="checkbox">

            <div class="select2-purple">
                <select class="select2" name="permissions[]"  id="e1" data-placeholder="Select The Permissions" multiple data-dropdown-css-class="select2-purple" style="width: 100%;">
                    @foreach ($permissions as $permission)
                        <option value="{{$permission->id}}" 
                            @foreach (old('permissions') ?? [] as $id)
                                @if ($id == $permission->id)
                                    {{ ' selected' }}
                                @endif
                            @endforeach>
                            {{$permission->name}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div> --}}
    <div class="mb-4">
        <button type="submit" style="width: 100%" class="btn btn-success">SAVE PROFILE</button>
    </div>
    </form>
</div>
@endsection

