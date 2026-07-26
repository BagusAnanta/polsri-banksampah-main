Project: Bank Sampah V2

Tech Stack:
- Laravel 8
- Filament 
- TailwindCSS
- MySQL

Roles:
- Masyarakat
- Admin Bank Sampah
- Super Admin

Business Rules:

Bank sampah polsri project V2 Feature :
- Login (NIK, password)
- Register (Nama lengkap, NIK, jenis kelamin, ho HP, email, alamat, foto ktp, password)
- Waiting Room (Verifikasi Masyarakat di Super Admin) (Masyarakat > S.Admin)

- User feature 
: Beranda Masyarakat (Halaman Dashboard Publik/Masyarakat) : 
    - Total poin -> sum poin, 
    - total gramasi -> sum gramasi, 
    - setor selesai -> count status selesai, 
    - Grafik Timestamp point per bulan, 
    - progress voucher
    - Menu cepat -> (setor sampah, Tukar Poin, Edukasi)
    - List Tiket serot terbaru
    - List Tiket Tukar Poin Terbaru 

: Halaman Daftar Pengajuan Setor Sampah
    - Buat Tiket
    - Total Gramasi -> sum gramasi
    - Menunggu (Status) -> count status menunggu
    - Selesai (Status) -> count status selesai
    - List Tiket -> jika status menunggu ada button (QR buat scan dan batalkan) -> untuk Button QR nanti ada modal buat munculin QR code

: Halaman Pengajuan 

: Tiket Sampah 
: Tiket Tukar Poin
: Daftar pengajuan tukar voucher

- Admin Bank Sampah Feature (Halaman untuk Admin Bank Sampah)
: Beranda (Total Tiket Setor, Tiket Stor Pending, Tiket Setor Selesai, Tiket Poin Pending) (Informasi Bank : Alamat, Jam operasi, No telp)
: Tiket Setor Sampah (Total tiket, menunggu proses, selesai, semua tiket yang dideposit masyarakat)
: Detail Tiket Setoran sampah (id tiket, identitas warga(nama, no telp, nik), detailsampah(estimasi berat, konversi), validasi tiket, kalkulasi gram dan kalkulasi point)
: Daftar Tiket Pengajuan Penukaran Voucher (Total tiket, menunggu proses, selesai, semua tiket voucher)
: Detail Tiket Setoran sampah (id poin, identitas warga(nama, no telp, nik), detail penukaran(hasil kalkulasi poin, tanggal pengajuan))
: Scan QR ticker pengajuan

- Super Admin Bank Sampah Feature (Halaman untuk Super Admin)
: Beranda (Total masyarakat, menunggu approval masyarakat, disetujui, ditolak, jumlah bank sampah, artikel edukasi)
: Daftar masyarakat yang register (Total masyarakat, menunggu persetujuan, telah disetujui)
: Halaman peninjauan pengajuan akun masyarakat (nama, nik, tanggal daftar, email, no HP, jenis kelamin, alamat, ktp, pendaftaran)
: Halaman profil masyarakat
: Daftar bank sampah (Total Bank Sampah)
: Daftar akun bank sampah (username, password, nama bank sampah, alamat, area/kecamatan, jam operasional, nomor telepon(optional), Deskripsi(optional))
: Edukasi masyarakat (jumlah artikel)
: Artikel (Judul artikel, Gambar sampul, Isi artikel)
: pengaturan sistem (konversi gramasi ke poin, konversi point ke voucher)
