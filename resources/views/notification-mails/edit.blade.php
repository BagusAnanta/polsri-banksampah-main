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
            <form action="{{ route('notification-mails.update', $notification_mail->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">

                    @include('components.form-message')

                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{$notification_mail->email}}"  placeholder="Masukan email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer bg-gray1" style="border-radius:0px 0px 10px 10px;">
                    <button type="submit" class="btn btn-success btn-footer">Simpan</button>
                    <a href="{{ route('notification-mails.index') }}" class="btn btn-secondary btn-footer">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')

@endpush