@extends('layouts.app')

@section('content')
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$table_title}}</h4>
                <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">ADD USER</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example3" class="display" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Avatar</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                @if(auth()->user()->can('user-delete') || auth()->user()->can('user-edit'))
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ asset('ui/images/profile/'.($user->avatar ?? 'user.png')) }}" width="40px"
                                        class="img-circle">
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username.'('. $user->getRoleNames()[0] .')'}}</td>
                                <td>{{ $user->email }}</td>
                                @if(auth()->user()->can('user-delete') || auth()->user()->can('user-edit'))
                                <td>
                                  <div class="d-flex">
                                      <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary shadow btn-xs sharp me-1"><i
                                              class="fas fa-pencil-alt"></i></a>
                                      <a href="#" onclick="modalDelete('User', '{{ $user->username }}', 'users/' + {{ $user->id }}, '/users/')" class="btn btn-danger shadow btn-xs sharp"><i
                                              class="fa fa-trash"></i></a>
                                  </div>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
