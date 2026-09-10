<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">

<div style="background-color: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); max-width: 600px; margin: 0 auto;">
    <div style="text-align: center; margin-bottom: 20px;">
        <h2 style="margin: 0; color: #333;">Reset Password</h2>
        <p style="color: #777; margin: 4px 0 0;">Bank Sampah</p>
    </div>

    <div style="background-color: #ecfeff; border: 1px solid #06b6d4; color: #075985; text-align: center; padding: 16px; border-radius: 8px; margin-bottom: 20px;">
        <strong style="font-size: 16px;">Permintaan Reset Password</strong>
    </div>

    <p>Dear <strong>{{ $user->name ?? $user->username ?? 'Pengguna' }}</strong>,</p>

    <p>Kami menerima permintaan untuk mengatur ulang password akun Anda. Klik tombol di bawah untuk membuat password baru. Link ini akan kedaluwarsa sesuai pengaturan aplikasi.</p>

    <div style="text-align:center; margin: 18px 0;">
        <a href="{{ $url }}" style="display:inline-block; background-color:#10b981; color:#fff; padding:12px 20px; text-decoration:none; border-radius:6px; font-weight:600;">Buat Password Baru</a>
    </div>

    <p>Atau salin dan tempel URL berikut ke browser Anda:</p>
    <p style="word-break:break-all; color:#064e3b; font-weight:600;">{{ $url }}</p>

    <p>Jika Anda tidak meminta perubahan password, abaikan email ini.</p>

    <br>
    <p>Salam,</p>
    <p style="margin: 0;"><em>Bank Sampah Sekanak</em></p>
</div>

</body>
</html>