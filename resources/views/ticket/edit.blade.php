@extends('layouts.app')

@section('style')

@endsection

@section('content')
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header text-cMasukan bg-gray1" style="border-radius:10px 10px 0px 0px;">
                <h3 class="card-title text-white">{{$page_title}}</h3>
            </div>

            <form action="{{ route('tickets.update', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">

                    @include('components.form-message')

                    <div class="form-group mb-3">
                        <label for="tanggal">Tanggal <small>(readonly)</small></label>
                        <input type="date" readonly class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ $ticket->tanggal }}"  placeholder="Masukan tanggal">

                        @error('tanggal')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="user_id">Nama Pembuat Ticket <small>(readonly)</small></label>
                        <input type="user_id" readonly class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" value="{{$ticket->user->name}}"  placeholder="Masukan user_id">
                        @error('user_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="judul">Judul</label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ $ticket->judul }}"  placeholder="Masukan judul">
                        @error('judul')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="Masukan deskripsi" id="" rows="3">{{$ticket->deskripsi}}</textarea>
                        @error('deskripsi')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="status">Status</label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror" id="">
                            <option value="open" {{($ticket->status == 'open') ? 'selected' : ''}}>Open</option>
                            @if (auth()->user()->getRoleNames()[0] == 'Admin')
                                <option value="close" {{($ticket->status == 'close') ? 'selected' : ''}}>Closed</option>
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
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <button class="btn btn-success" id="uploadDocument" style="float: right">Upload File</button>
                    </div>
                </div>
                @include('components.form-message')

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
                                        {{-- <form action="{{ route('tickets.delete-doc-trouble', [$ticket->id, $doc->file_upload]) }}" method="POST" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Apa Anda yakin ingin menghapus dokumen ini?')" class="btn btn-sm btn-danger"><i
                                                class="fa fa-trash"></i></button>
                                        </form> --}} 

                                        <button onclick="confirmButton({{$ticket->id}}, {{$doc->id}}, '{{route('tickets.delete-doc-trouble')}}')" class="btn btn-sm btn-danger"><i
                                            class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@include('ticket.modal')
@endsection

@push('script')
<script>
    $('#uploadDocument').click(function () {
        $('#documentModal').modal('show');
    });

    function upload() {
        var files = $('input[name="doc"]').prop('files'); // Ambil semua file yang dipilih
        var formData = new FormData();
        // Tambahkan semua file ke FormData
        for (var i = 0; i < files.length; i++) {
            formData.append('docs[]', files[i]); // Gunakan 'docs[]' agar array file diterima di server
        }

        // Tambahkan token CSRF ke FormData
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: "{{ route('tickets.upload-doc-trouble', $ticket->id) }}",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
                $('#documentModal').modal('hide');
                location.reload();
            }
        });
    }

    function confirmButton(id, docId, url) {
        // jika ya maka akan menghapus dokumen
        console.log(id, docId, url);
        $.confirm({
            title: 'Hapus Dokumen',
            content: 'Apakah Anda yakin ingin menghapus dokumen ini?',
            buttons: {
                delete: {
                    text: 'delete',
                    action: function () {
                        $.ajax({
                            type: 'POST',
                            url: url,
                            data: {
                                _token: '{{ csrf_token() }}',
                                id : id,
                                docId : docId
                            },
                            success: function (data) {
                                Swal.fire({
                                title: "Berhasil Dihapus!",
                                icon: "success"
                                }).then(() => {
                                    location.reload(); // Memuat ulang halaman setelah alert sukses
                                });
                                // location.reload();
                                console.log(data);
                            },
                            error: function (data) {
                                $.alert('Failed!');
                                console.log(data);
                            }
                        });
                    }
                },
                cancel: function () {
                    
                }
            }
        });
        
    }

</script>
@endpush