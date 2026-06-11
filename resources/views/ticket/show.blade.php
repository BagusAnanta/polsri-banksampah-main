@extends('layouts.app')

@push('css')
<style>
    .scrollable {
        overflow-y: auto;
    }

</style>
@endpush

@section('content')
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header text-cMasukan bg-gray1" style="border-radius:10px 10px 0px 0px;">
                <h3 class="card-title text-white">{{$page_title}}</h3>
            </div>

            <div class="card-body">

                @include('components.form-message')

                <div class="form-group mb-3">
                    <label for="tanggal">Tanggal <small>(readonly)</small></label>
                    <input type="date" readonly class="form-control @error('tanggal') is-invalid @enderror" id="tanggal"
                        name="tanggal" value="{{ $ticket->tanggal }}" placeholder="Masukan tanggal">

                    @error('tanggal')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="user_id">Nama Pembuat Ticket <small>(readonly)</small></label>
                    <input type="user_id" readonly class="form-control @error('user_id') is-invalid @enderror"
                        id="user_id" name="user_id" value="{{$ticket->user->name}}" placeholder="Masukan user_id">
                    @error('user_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="judul">Judul <small>(readonly)</small></label>
                    <input type="text" readonly class="form-control @error('judul') is-invalid @enderror" id="judul"
                        name="judul" value="{{ $ticket->judul }}" placeholder="Masukan judul">
                    @error('judul')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="deskripsi">Deskripsi <small>(readonly)</small></label>
                    <textarea name="deskripsi" readonly class="form-control @error('deskripsi') is-invalid @enderror"
                        placeholder="Masukan deskripsi" id="" rows="3">{{$ticket->deskripsi}}</textarea>
                    @error('deskripsi')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="status">Status <small>(readonly)</small></label>
                    <select name="status" class="form-control @error('status') is-invalid @enderror" id=""
                        {{($ticket->status != null && auth()->user()->getRoleNames()[0] != 'Admin') ? 'disabled="true"' : ''}}>
                        <option value="open" {{($ticket->status == 'open') ? 'selected' : ''}}>Open</option>
                        <option value="pending" {{($ticket->status == 'pending') ? 'selected' : ''}}>Pending
                        </option>
                        <option value="close" {{($ticket->status == 'close') ? 'selected' : ''}}>Closed</option>
                    </select>
                    @error('status')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title
                ">Lampiran</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example3" class="display">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Document</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ticket->uploadDocTrouble as $doc)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$doc->file_upload}}</td>
                                <td>
                                    <a href="{{asset('doc_troubles/'. $doc->file_upload)}}" target="__blank" class="btn btn-sm btn-success download-btn">Preview</a>
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
<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title
                ">Dokumen Penyelesaian Tiket</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example3" class="display">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Document</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ticket->uploadDoc as $doc)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$doc->file_upload}}</td>
                                <td>
                                    <a href="{{asset('docs/'. $doc->file_upload)}}" target="__blank" class="btn btn-sm btn-success download-btn">Preview</a>
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
