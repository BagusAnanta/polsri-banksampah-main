@extends('layouts.app')

@push('css')
<style>
    .text-blue {
        color: #71afde;
    }
</style>
    @endpush

@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{$page_title}}</h4>
                    <a href="{{ route('tickets.create') }}" class="btn btn-sm btn-primary">ADD TICKET</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @include('components.flash-message')
                        <table id="example3" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Tiket</th>
                                    <th>Tanggal</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th>Update</th>
                                    {{-- <th>Detail</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tickets as $ticket)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$ticket->nomor_tiket}}</td>
                                    <td>{{$ticket->created_at}}</td>
                                    <td>{{$ticket->judul}}</td>
                                    <td>{{$ticket->deskripsi}}</td>
                                    <td>{{ucfirst($ticket->user->name) . ' - ('. $ticket->user->getRoleNames()[0] .')'}}</td>
                                    {{-- <td>
                                        @if ($ticket->status == 'open')
                                            <span style="font-size: 12px;" class="badge badge-success">{{$ticket->status}}</span>
                                        @elseif ($ticket->status == 'pending')
                                            <span style="font-size: 12px;" class="badge badge-warning">{{$ticket->status}}</span>    
                                        @else 
                                            <span style="font-size: 12px;" class="badge badge-danger">{{$ticket->status}}</span>    
                                        @endif
                                    </td> --}}
                                    <td>
                                        @if ($ticket->status == 'open')
                                            <i class="fa fa-circle text-danger me-1"></i>Open
                                        @elseif ($ticket->status == 'progress')
                                            <i class="fa fa-circle text-blue me-1"></i>Progress by {{$ticket->findUser($ticket->progress_by)}}
                                        @else
                                            <i class="fa fa-circle text-success me-1"></i>Closed by {{$ticket->findUser($ticket->closed_by)}}
                                        @endif
                                    </td>
                                    <td>{{$ticket->updated_at}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-success light" data-bs-toggle="dropdown">
                                                <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                            </button>
                                            <div class="dropdown-menu">
                                                @if ($ticket->status != 'close')
                                                    <a class="dropdown-item" href="{{ route('tickets.edit', $ticket->id) }}">Edit</a>
                                                @else
                                                    <a class="dropdown-item" href="{{ route('tickets.show', $ticket->id) }}">Detail</a>
                                                @endif
                                                <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" style="display: inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Apa Anda yakin ingin menghapus tiket ini?')" class="dropdown-item">Delete</button>
                                                </form>
                                                @if ($ticket->status != 'close' && auth()->user()->getRoleNames()[0] != 'HRD')
                                                    <a href="{{ route('tickets.update-ticket', $ticket->id) }}" class="dropdown-item">Submit</a>
                                                @endif
                                            </div>
                                        </div>
                                        {{-- <div class="d-flex">
                                            @if ($ticket->status != 'close')
                                                <a href="{{ route('tickets.update-ticket', $ticket->id) }}" class="btn btn-sm btn-primary mr-2">Submit</a>
                                            @endif
                                            <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-sm btn-warning mr-2">Edit</a>
                                            <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Apa Anda yakin ingin menghapus tiket ini?')" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </div> --}}
                                    </td>
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

@push('script')
@endpush