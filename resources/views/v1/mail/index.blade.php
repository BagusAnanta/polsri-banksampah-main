<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Tiket Baru</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">

<div style="background-color: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
    <h2 style="color: #333;">Pemberitahuan Tiket Baru: {{$ticket->nomor_tiket}} - {{$ticket->judul}}</h2>
    <p>Dear Tim Teknis,</p>
    <p>Ini adalah pemberitahuan bahwa tiket baru telah dibuat dan membutuhkan perhatian Anda. Berikut adalah detail dari tiket tersebut:</p>
    <ul>
        <li><strong>Nomor Tiket:</strong> {{$ticket->nomor_tiket}}</li>
        <li><strong>Judul Masalah:</strong> {{$ticket->judul}}</li>
        <li><strong>Tanggal Tiket:</strong> {{$ticket->tanggal}}</li>
        <li><strong>Deskripsi Masalah:</strong> {{$ticket->deskripsi}}</li>
        <li><strong>Status:</strong> {{$ticket->status}}</li>
        <li><strong>Pelapor:</strong> {{$ticket->user->name}}</li>
    </ul>
    {{-- <p>Mohon segera meninjau dan menindaklanjuti tiket ini. Anda dapat menindaklanjuti tiket dengan mengunjungi link berikut:</p>
    <p><a href="[URL Tiket]" style="color: #1a73e8; text-decoration: none;">Klik di sini untuk menindaklanjuti tiket</a></p>
    <br> --}}
    <p>Terima kasih atas kerjasama dan dedikasi Anda.</p>
    <br>
    <p>Salam,</p>
    <p><em>Sistem Manajemen Tiket</em></p>
</div>

</body>
</html>
