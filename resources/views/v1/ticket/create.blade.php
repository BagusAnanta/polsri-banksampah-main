@extends('layouts.app')

@push('style')

@endpush

@section('content')
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header text-cMasukan bg-gray1" style="border-radius:10px 10px 0px 0px;">
                <h3 class="card-title text-white">{{$page_title}}</h3>
            </div>
            <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card-body">

                    @include('components.form-message')

                    <div class="form-group mb-3">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" readonly class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}"  placeholder="Masukan tanggal">

                        @error('tanggal')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="user_id">Nama Pembuat Ticket</label>
                        <input type="user_id" readonly class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" value="{{auth()->user()->name}}"  placeholder="Masukan user_id">
                        @error('user_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="judul">Judul</label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}"  placeholder="Masukan judul">
                        @error('judul')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="Masukan deskripsi" id="" rows="3">{{old('deskripsi')}}</textarea>
                        @error('deskripsi')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="upload_docs">Upload Dokumen</label>
                        <input type="file" name="docs[]" id="docs" class="form-control" multiple>
                    </div>
                    <div class="form-group mb-3">
                        <label for="status">Status</label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror" id="">
                            <option value="open">Open</option>
                            @if (auth()->user()->getRoleNames()[0] == 'Admin')
                                <option value="close">Closed</option>
                            @endif
                        </select>
                        @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer bg-gray1" style="border-radius:0px 0px 10px 10px;">
                    <button type="submit" class="btn btn-success btn-footer">Simpan</button>
                    <a href="{{ route('tickets.index') }}" class="btn btn-secondary btn-footer">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')

@endpush