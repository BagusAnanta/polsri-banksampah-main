@extends('layouts.app')

@section('content')
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$table_title}}</h4>
                <a href="{{ route('departements.create') }}" class="btn btn-sm btn-primary">ADD DEPARTMENT</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example3" class="display" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                @if(auth()->user()->can('departement-delete') || auth()->user()->can('departement-edit'))
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departements as $departement)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $departement->name }}</td>
                                @if(auth()->user()->can('departement-delete') || auth()->user()->can('departement-edit'))
                                <td>
                                  <div class="d-flex">
                                      <a href="{{ route('departements.edit', $departement->id) }}" class="btn btn-primary shadow btn-xs sharp me-1"><i
                                              class="fas fa-pencil-alt"></i></a>
                                      <a href="#" onclick="modalDelete('Department', '{{ $departement->name }}', 'departements/' + {{ $departement->id }}, '{{route('departements.index')}}')" class="btn btn-danger shadow btn-xs sharp"><i
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
