Baca dokumentasi dan kode yang sudah dibuat sebagai dokumentasi

Kamu adalah fullstack developer dengan menggunakan tech stack Laravel, Blade, Tailwind, dan DaisyUI

Tugasmu : 

Task 1 :
Hapus dummy data yang ada di route dashboard dan ganti dengan route berdasarkan controller yang sudah dibuat (lanjut intruksi selanjutnya)

Task 2:
- Perbaiki route Dahsboard agar bisa direct ke dashboard V2 dengan tetap mempertahankan direct dashboard V1 karena ketika sama terjadi konflik, lalu integrasikan data ke Dashboard masyarakat yang belum terimplementasi seperti grafik timeline poin per bulan, daftar tiket setor sampah terbaru, dan daftar tiket tukar poin terbaru 

Aturan Task 2 :
1. gunakan controller yang sudah saya buatkan dan jika ada beberapa fungsi yang belum ada, maka tambahkan di controller 
2. jangan ubah controller yang sudah ada, hanya boleh tambahkan, dan jika memang butuh diubah controller, model atau field database di migration, maka konfirmasi ke saya terlebih dahulu.

Task 3:
- Buat modal yang digunakan untuk membuat tiket (untuk tiket-poin-create (Halaman pengajuan setor sampah) dan tiket-sampah-create (Halaman pengajuan tukar voucher)) dengan field sebagai berikut : 

Halaman Buat tiket setor sampah field 
1. Berat estimasi -> set default berat aktual
2. Nama bank sampah / nama seluruh bank sampah yang teregistrasi  

Halaman Buat tiket setor Voucher
1. Jumlah Poin (User bisa masukkin jumlah poin disini juga)
2. jumlah Voucher (jumlah voucher yang mau ditukar, hitungannya 1 voucher itu == jumlah poin yang sudah ditentukan, jadi kalau kurang dia harusnya ngak bisa tukar)
3. Nama bank sampah (list bank sampah dimana user setor sampah)

Aturan Task 3 : 

buat dan referensi berdasarkan Analisis_UIUX_Bank_Sampah dan dengan aturan berikut :
1. gunakan blade, DaisyUI dan Tailwind untuk frontend (sarankan gunakan banyak dari DaisyUI daripada Tailwind mentah)
2. untuk Jumlah Poin dan Jumlah voucher pada Halaman buat tiket setor voucher / poin buat field nya otomatis berubah (jadi saya ingin otomatis menghitung secara realtime di frontend dan menampilkannya langsung jika kurang atau cukup, namun data poin yang sudah ditetapkan perlu diambil terlebih dahulu nanti di pengaturan yang sudah ada di controller yang nantinya digunakan untuk membuat kondisi if) jika user memasukkan salah satu field baik itu field poin atau voucher maka akan mengisi salah satu field itu, 

contoh : jadi misal user masukkin Jumlah voucher, otomatis jumlah poinnya akan muncul di field poin (jadi jumlah voucher berdasarkan jumlah banyak poin yang dimasukan user dan dibandingkan dengan jumlah ketentuan poin yang sudah ditetapkan, jika kurang maka akan otomatis ada error dibawah field (buat saja di bawah field voucher jadi fieldnya urutannya poin baru voucher)) dan sebaliknya kalau user masukkin poin maka nanti akan menghitung voucher yang bisa didapatkan dan ditampilkan jumlah voucher yang bisa didapatkan dan jika kurang maka akan muncul error dibawah field.

3. untuk nama  bank sampah pada Halaman Buat tiket setor sampah, tampilkan seluruh list nama bank sampah (buat dalam drop down)yang sudah terverifikasi dan untuk nama  bank sampah pada halaman buat tiket setor voucher, tampilkan seluruh list bank sampah yang dimana user mengajukan tiket setor sampah sebelumnya, namun dengan catatan tiket setor sampah sebelumnya harus dalam status selesai dan nama bank sampah dihapus pada list untuk tiket setor voucher jika status tiket setor voucher dan tiket setor sampah sudah selesai dan ini nanti akan dicatat di history bank sampah mana dan dicatat di total_selesai di table masyarakat.

4. ikuti tema dari file analisis UIUX_Bank_Sampah 

Task 4 : 
check dan perbaiki tiket-sampah-show dan tiket-poin-show dan integrasikan dengan controller yang sudah ada 

Aturan Task 4 :
1. gunakan controller yang sudah saya buatkan dan jika ada beberapa fungsi yang belum ada, maka tambahkan di controller 
2. jangan ubah controller yang sudah ada hanya boleh tambahkan, dan jika memang butuh diubah controller, model atau field database di migration, maka konfirmasi ke saya terlebih dahulu.

Task 5:
Tambahkan list tiket setor sampah dan tiket setor poin sampah yang sudah selesai statusnya pada halaman history/riwayat, jadi isinya berupa history berupa tiket sampah dan tiket poin sampah yang sudah selesai status keduannya dan history ini dapat bertambah jika urutan selesainya berurutan jadi dimulai dari tiket tukar sampah dahulu jika selesai lanjut tiket tukar poin dan jika sudah selesai keduannya maka baru dicatat di history

Aturan Task 5:
1. gunakan controller yang sudah saya buatkan dan jika ada beberapa fungsi yang belum ada, maka tambahkan di controller
2. jangan ubah controller yang sudah ada hanya boleh tambahkan, dan jika memang butuh diubah controller, model atau field database di migration, maka konfirmasi ke saya terlebih dahulu.
3. untuk tampilannya dibuat seperti list tiket sampah atau tiket poin, namun bedanya hanya bedanya tidak ada tombol qrcode dan batalkan hanya menampilkan id tiket, tanggal, nama bank sampah, dan statusnya saja.
