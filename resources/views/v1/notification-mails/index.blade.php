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
                    <a href="{{ route('notification-mails.create') }}" class="btn btn-sm btn-primary">TAMBAH EMAIL</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @include('components.flash-message')
                        <table id="example3" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notification_mails as $mail)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$mail->email}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-success light" data-bs-toggle="dropdown">
                                                <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                            </button>
                                            <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('notification-mails.edit', $mail->id) }}">Edit</a>
                                                <form action="{{ route('notification-mails.destroy', $mail->id) }}" method="POST" style="display: inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Apa Anda yakin ingin menghapus email ini?')" class="dropdown-item">Delete</button>
                                                </form>
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