<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isApproved ? 'Akun Disetujui' : 'Akun Ditolak' }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">

<div style="background-color: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); max-width: 600px; margin: 0 auto;">
    <div style="text-align: center; margin-bottom: 20px;">
        <h2 style="margin: 0; color: #333;">Hasil Verifikasi Akun</h2>
        <p style="color: #777; margin: 4px 0 0;">Bank Sampah</p>
    </div>

    @if($isApproved)
    <div style="background-color: #ecfdf5; border: 1px solid #10b981; color: #047857; text-align: center; padding: 16px; border-radius: 8px; margin-bottom: 20px;">
        <strong style="font-size: 16px;">Akun Anda Telah Disetujui</strong>
    </div>
    @else
    <div style="background-color: #fef2f2; border: 1px solid #ef4444; color: #b91c1c; text-align: center; padding: 16px; border-radius: 8px; margin-bottom: 20px;">
        <strong style="font-size: 16px;">Akun Anda Ditolak</strong>
    </div>
    @endif

    <p>Dear <strong>{{ $masyarakat->user->name ?? '-' }}</strong>,</p>

    @if($isApproved)
    <p>Selamat, pendaftaran akun Anda sebagai masyarakat Bank Sampah telah <strong>disetujui</strong>. Anda sekarang dapat masuk ke platform menggunakan NIK atau Username sebagai identitas login.</p>
    @else
    <p>Mohon maaf, pendaftaran akun Anda sebagai masyarakat Bank Sampah <strong>ditolak</strong> oleh admin. Anda tidak dapat mengakses platform lebih lanjut.</p>
    @endif

    <div style="background-color: #f9fafb; border-radius: 8px; padding: 16px; margin: 20px 0;">
        <p style="margin: 0 0 8px; color: #555; font-weight: bold;">Detail Pengajuan</p>
        <table style="width: 100%; font-size: 14px; border-collapse: collapse;">
            <tr>
                <td style="padding: 4px 0; color: #666;">Nama</td>
                <td style="padding: 4px 0; color: #333; font-weight: 600;">{{ $masyarakat->user->name ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding: 4px 0; color: #666;">Username</td>
                <td style="padding: 4px 0; color: #333; font-weight: 600;">{{ $masyarakat->user->username ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding: 4px 0; color: #666;">Email</td>
                <td style="padding: 4px 0; color: #333; font-weight: 600;">{{ $masyarakat->user->email ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding: 4px 0; color: #666;">NIK</td>
                <td style="padding: 4px 0; color: #333; font-weight: 600;">{{ $masyarakat->decrypted_nik ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding: 4px 0; color: #666;">Status</td>
                <td style="padding: 4px 0; color: #333; font-weight: 600;">{{ $status }}</td>
            </tr>
        </table>
    </div>

    @if(!$isApproved)
    <div style="background-color: #fef2f2; border-radius: 8px; padding: 16px; margin: 20px 0;">
        <p style="margin: 0 0 8px; color: #b91c1c; font-weight: bold;">Alasan Penolakan</p>
        <p style="margin: 0; color: #7f1d1d; font-size: 14px;">{{ $alasan ?? 'Alasan tidak disebutkan.' }}</p>
    </div>
    @endif

    <p>Apabila Anda memiliki pertanyaan lebih lanjut, silakan hubungi admin Bank Sampah.</p>

    <br>
    <p>Salam,</p>
    <p style="margin: 0;"><em>Admin Bank Sampah</em></p>
</div>

</body>
</html>