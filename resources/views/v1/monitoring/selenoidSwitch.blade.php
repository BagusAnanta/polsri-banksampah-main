@extends('layout-mobile.app')
@section('header')
    <header class="header header-fixed">
        <div class="header-content">
            <div class="left-content">
                @php
                    $previousUrl = session('previous_url', route('dashboard')); // Default ke halaman index

                    // Validasi URL agar hanya dari domain aplikasi
                    if (!str_contains($previousUrl, config('app.url'))) {
                        $previousUrl = route('jenis_sampahs.index'); // Pastikan URL aman
                    }
                @endphp

                <a href="{{ $previousUrl }}" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Kontrol Selenoid</h4>
            </div>
        </div>
    </header>
@endsection
@section('content')

<div class="dz-list style-3">
    <ul>
    @foreach($selenoid_sensor as $selenoid)
    <li>
        <a class="item-content">
            <div class="d-flex align-items-center w-100">
                <div class="d-flex align-items-center">
                    <!-- <div class="dz-icon icon-xs icon-fill me-2">
                        <i class="fi fi-rr-bold text-dark"></i>
                    </div> -->
                    <span class="title">Selenoid {{$selenoid->sensor_name}} - {{$selenoid->status}}</span>
                </div>
                <div class="ms-auto">
                    <button class="btn btn-sm btn-success" onclick="changeStatusSelenoid('{{$selenoid->sensor_name}}', 1)">On</button>
                    <button class="btn btn-sm btn-danger" onclick="changeStatusSelenoid('{{$selenoid->sensor_name}}', 0)">Off</button>
                </div>
            </div>
        </a>
    </li>
    @endforeach
    </ul>
</div>
@endsection
@push('script')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>


    function changeStatusSelenoid(topic, status) {
        if (!topic) {
            console.error("Topic tidak boleh kosong!");
            return;
        }

        // Emit event realtime ke server socket.io
        socket.emit('selenoid', { topic: topic, status: status });

        console.log(`Emit sent: topic=${topic}, status=${status}`);
    }
</script>
@endpush

