<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\BankSampahController;
use App\Http\Controllers\BankSampahUserController;
use App\Http\Controllers\BoxSampahController;
use App\Http\Controllers\JenisSampahController;
use App\Http\Controllers\LaporanPengaduanController;
use App\Http\Controllers\ListproductController;
use App\Http\Controllers\NotificationMailController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RiwayatSetorController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\TiketsetorsampahController;
use App\Http\Controllers\TikettukarpoinController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\MasyarakatController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PasswordResetController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

# test route (default route (this route I want made this automatic directing into login page))
Route::get('/', function () {
    return redirect()->route('login');
});

// Login route 
Route::get('/login', function () {
    $data['page_title'] = "Login";
    return view('v2.auth.login', $data);
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login');

// Register route
Route::get('/register', function () {
    $data['page_title'] = "Register";
    return view('v2.auth.register', $data);
})->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register');

// Router 
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
Route::get('/profil', [AuthController::class, 'profile'])->name('profil');

// Forget Password route
Route::get('/forgot-password', function (){
    $data['page_title'] = "Lupa Password";
    return view('v2.auth.forgetpassword.forgot-password', $data);
})->name('forget-password');

// submit email to send reset link
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');

// page shown after sending reset link
Route::get('/forgot-password/sent', function () {
    $data['email'] = session('email', old('email'));
    return view('v2.auth.forgetpassword.forgot-password-sent', $data);
})->name('forgot-password.sent');

// Reset password form (link from email)
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');

// Perform password update
Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');

// Status page after attempting reset
Route::get('/reset-password-status', function () {
    $data['status'] = session('status', 'failed');
    $data['message'] = session('message', '');
    return view('v2.auth.forgetpassword.reset-password-status', $data);
})->name('reset-password-status');

Route::get('/help', function() {
    return view('v2.help');
})->name('help');

 // for V2 notification
Route::middleware('auth')->prefix('notifications')->group(function () {
    Route::get('/', [NotificationController::class, 'notificationIndex'])->name('notifications.index');
    Route::get('/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
    Route::patch('/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::patch('/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
});

// ====== V2 Admin & Super Admin Routes (inside auth middleware group) ======

/**
 * PRIVATE PAGE SIDE (IT CAN ACCESS WHILE USER ALREADY LOGIN)
 */

# Version 1 middleware 

Route::prefix('v1')->middleware(['auth:web', 'role:Admin|Super Admin'])->group(function () {

    // Master Data
    Route::get('master-data', function () {
        $data['page_title'] = 'Master Data';
        $data['breadcumb'] = 'Master Data';
        return view('master-data.index', $data);
    })->name('master-data.index');

    //Monitoring
    Route::get('/monitoring/sensor', [MonitoringController::class, 'index'])->name('monitoring.sensor');
    Route::get('/control/selenoid', [MonitoringController::class, 'selenoidControl'])->name('control.selenoid');
    Route::post('/selenoid/send-status', [MonitoringController::class, 'changeStatusSelenoid'])->name('change-status-selenoid');

    //Maps
    Route::get('maps', [DashboardController::class, 'maps'])->name('maps');

    // Departement
    Route::resource('departements', DepartementController::class);
    Route::resource('tickets', TicketController::class);
    Route::get('update-ticket/{id}', [TicketController::class, 'updateTicket'])->name('tickets.update-ticket');
    Route::post('/tickets/{id}/upload', [TicketController::class, 'uploadDoc'])->name('tickets.upload-doc');
    Route::post('/tickets/{id}/uploadDocTrouble', [TicketController::class, 'uploadDocTrouble'])->name('tickets.upload-doc-trouble');
    Route::patch('/tickets/{id}/update-status', [TicketController::class, 'updateStatus'])->name('tickets.update-status');

    Route::post('/tickets/document/delete/creator', [TicketController::class, 'deleteDoc'])->name('tickets.delete-document');
    Route::post('/tickets/delete-doc-trouble', [TicketController::class, 'deleteDocTrouble'])->name('tickets.delete-doc-trouble');
    // Users
    Route::patch('change-password', [AuthController::class, 'changePassword'])->name('users.change-password');
    Route::get('users', [AuthController::class, 'listUsers'])->name('users.index');
    Route::get('users/create', [AuthController::class, 'createUser'])->name('users.create');
    Route::post('users', [AuthController::class, 'storeUser'])->name('users.store');
    Route::get('users/{user}', [AuthController::class, 'showUser'])->name('users.show');
    Route::get('users/{user}/edit', [AuthController::class, 'editUser'])->name('users.edit');
    Route::put('users/{user}', [AuthController::class, 'updateUser'])->name('users.update');
    Route::delete('users/{user}', [AuthController::class, 'destroyUser'])->name('users.destroy');

    // Box Sampah
    Route::get('box-sampahs', [BoxSampahController::class, 'index'])->name('box-sampahs.index');
    Route::get('box-sampahs/create', [BoxSampahController::class, 'create'])->name('box-sampahs.create');
    Route::post('box-sampahs', [BoxSampahController::class, 'store'])->name('box-sampahs.store');
    Route::get('box-sampahs/show/{id}', [BoxSampahController::class, 'show'])->name('box-sampahs.show');
    Route::get('box-sampahs/edit/{id}', [BoxSampahController::class, 'edit'])->name('box-sampahs.edit');
    Route::put('box-sampahs/put/{id}', [BoxSampahController::class, 'update'])->name('box-sampahs.update');
    Route::delete('box-sampahs/delete/{id}', [BoxSampahController::class, 'destroy'])->name('box-sampahs.destroy');

    // Laporan Pengaduan
    Route::resource('laporan-pengaduans', LaporanPengaduanController::class);
    Route::get('laporan-pengaduans/show/{id}', [LaporanPengaduanController::class, 'showAdmin'])->name('laporan-pengaduans.showAdmin');
    Route::get('laporan-pengaduans-nasabah/', [LaporanPengaduanController::class, 'indexNasabah'])->name('laporan-pengaduans.indexNasabah');
    Route::delete('laporan-pengaduans/delete/{id}', [LaporanPengaduanController::class, 'destroy'])->name('laporan-pengaduans.destroy');
    Route::delete('laporan-pengaduans/deleteAdmin/{id}', [LaporanPengaduanController::class, 'destroyAdmin'])->name('laporan-pengaduans.destroyAdmin');

    // Product List
    Route::resource('products-list', ListproductController::class); //penyetor (user)
    Route::resource('data-products', ProductController::class); //pengepul (admin)

    // Transaksi
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::post('/transaksi/update', [TransaksiController::class, 'updateKredit'])->name('transaksi.updateKredit');
    Route::get('download-tabungan-pdf', [TransaksiController::class, 'tabunganPdf'])->name('download-tabungan-pdf');

    // Transaksi Kredit Admin
    Route::get('admin/tabungan', [TransaksiController::class, 'adminIndex'])->name('transaksi.admin.index');
    Route::patch('/transaksi/{id}/approve', [TransaksiController::class, 'approvedKredit'])->name('transaksi.approvedKredit');

    // Orders List
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.my-orders');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::post('/orders/{order}/update-status', [OrderController::class, 'update'])->name('orders.update');

    // History Log
    Route::resource('notification-mails', NotificationMailController::class);
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('riwayat-setor/{month?}', [RiwayatSetorController::class, 'index'])->name('riwayat-setor');
    Route::resource('jenis_sampahs', JenisSampahController::class);
    Route::resource('bank_sampahs', BankSampahController::class);
    
    // Route::put('bank-sampah/approve/{user_id}', [BankSampahController::class, 'approve'])->name('bank-sampah.approve');
    Route::put('/bank-sampah/update-status/{user_id}', [BankSampahController::class, 'updateStatus'])->name('bank-sampah.updateStatus');
    Route::get('bank-sampah/detail/{user_id}', [BankSampahController::class, 'detail'])->name('bank-sampah.detail');


    // Slip Penyetor
    Route::get('download-slip-penyetoran-bulan-pdf', [RiwayatSetorController::class, 'slipPenyetoranBulanPdf'])
        ->name('download-slip-penyetoran-bulan-pdf');

    // Nota PDF
    // Route::get('download-nota-pdf/{date}', [RiwayatSetorController::class, 'notaPdf'])->name('download-nota-pdf');
    Route::get('download-nota-pdf', [TransaksiController::class, 'notaPdf'])->name('download-nota-pdf');


    Route::get('/dashboard/search', [DashboardController::class, 'search'])->name('dashboard.search');
});


# Version 2 middleware 
Route::prefix('v2')->middleware('auth:web')->group(function () {
    Route::resource('departements', DepartementController::class);
    Route::resource('tickets', TicketController::class);

    Route::get('users', [AuthController::class, 'listUsers'])->name('users.index');
    Route::get('users/create', [AuthController::class, 'createUser'])->name('users.create');
    Route::post('users', [AuthController::class, 'storeUser'])->name('users.store');
    Route::get('users/{user}', [AuthController::class, 'showUser'])->name('users.show');
    Route::get('users/{user}/edit', [AuthController::class, 'editUser'])->name('users.edit');
    Route::put('users/{user}', [AuthController::class, 'updateUser'])->name('users.update');
    Route::delete('users/{user}', [AuthController::class, 'destroyUser'])->name('users.destroy');

    // user profile route (masyarakat profile route)
    Route::get('/profile-masyarakat/{id}', [MasyarakatController::class, 'masyarakatProfile'])->name('profile-masyarakat');

    Route::get('/waiting', function () {
        $data['page_title'] = "Waiting Room";
        return view('v2.waiting.waiting', $data);
    })->name('waiting');

    // V2 Dashboard route (must be before resource to avoid conflict)
    Route::get('/dashboard', [DashboardController::class, 'indexV2'])->name('dashboard');

    Route::get('/tiket-sampah', [TiketsetorsampahController::class, 'indexV2'])->name('tiket-sampah.index');
    Route::get('/tiket-sampah/create', [TiketsetorsampahController::class, 'create'])->name('tiket-sampah.create');
    Route::post('/tiket-sampah', [TiketsetorsampahController::class, 'store'])->name('tiketsetorsampahs.store');
    Route::get('/tiket-sampah/{id}', [TiketsetorsampahController::class, 'showV2'])->name('tiket-sampah.show');
    Route::put('/tiket-sampah/{id}/cancel', [TiketsetorsampahController::class, 'cancel'])->name('tiket-sampah.cancel');

    Route::get('/tiket-poin', [TikettukarpoinController::class, 'indexV2'])->name('tiket-poin.index');
    Route::get('/tiket-poin/create', [TikettukarpoinController::class, 'create'])->name('tiket-poin.create');
    Route::post('/tiket-poin', [TikettukarpoinController::class, 'store'])->name('tikettukarpoin.store');
    Route::get('/tiket-poin/{id}', [TikettukarpoinController::class, 'showV2'])->name('tiket-poin.show');
    Route::put('/tiket-poin/{id}/cancel', [TikettukarpoinController::class, 'cancel'])->name('tiket-poin.cancel');

    Route::get('/edukasi-masyarakat', [ArtikelController::class, 'indexmasyarakat'])->name('edukasi-masyarakat.index');
    Route::get('/edukasi-masyarakat/{id}', [ArtikelController::class, 'showmasyarakat'])->name('edukasi-masyarakat.show');
    Route::get('/riwayat', [DashboardController::class, 'getRiwayat'])->name('riwayat.index');

    Route::resource('bank-sampahs', BankSampahController::class);
    Route::resource('box-sampahs', BoxSampahController::class);
    Route::resource('jenis-sampahs', JenisSampahController::class);
    Route::resource('laporan-pengaduans', LaporanPengaduanController::class);
    Route::resource('products-list', ListproductController::class);
    Route::resource('data-products', ProductController::class);
    Route::resource('notification-mails', NotificationMailController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('riwayat-setor', RiwayatSetorController::class);
    Route::resource('masyarakats', AuthController::class);
    Route::resource('banksampahusers', BankSampahUserController::class);
    Route::resource('tiketsetorsampahs', TiketsetorsampahController::class);
    Route::resource('tikettukarpoin', TikettukarpoinController::class);
    Route::resource('artikels', ArtikelController::class);
    Route::resource('settings', SettingController::class);
    Route::resource('monitoring', MonitoringController::class);
    Route::resource('transaksi', TransaksiController::class);

    // ====== V2 Admin Bank Sampah Routes ======
    Route::prefix('admin')->name('admin.')->middleware('role:Admin Bank Sampah|Super Admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminBankSampahDashboard'])->name('dashboard');

        // bank sampah profile route (bank sampah profile route)
        Route::get('/profile-banksampah/{id}', [BankSampahUserController::class, 'bankSampahProfile'])->name('profile-banksampah');

        Route::get('/tiket-setor', [TiketsetorsampahController::class, 'adminIndex'])->name('tiket-setor.index');
        Route::get('/tiket-setor/{id}', [TiketsetorsampahController::class, 'adminShow'])->name('tiket-setor.show');
        Route::put('/tiket-setor/{id}/validate', [TiketsetorsampahController::class, 'adminValidate'])->name('tiket-setor.validate');

        Route::get('/tiket-poin', [TikettukarpoinController::class, 'adminIndex'])->name('tiket-poin.index');
        Route::get('/tiket-poin/{id}', [TikettukarpoinController::class, 'adminShow'])->name('tiket-poin.show');
        Route::put('/tiket-poin/{id}/validate', [TikettukarpoinController::class, 'adminValidate'])->name('tiket-poin.validate');

        Route::get('/scan', [TiketsetorsampahController::class, 'adminScan'])->name('scan');
    });

    // ====== V2 Super Admin Routes ======
    Route::prefix('super-admin')->name('sa.')->middleware('role:Super Admin')->group(function () {
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');

        Route::get('/masyarakat', [SuperAdminController::class, 'masyarakatIndex'])->name('masyarakat.index');
        Route::get('/masyarakat/{id}/review', [SuperAdminController::class, 'masyarakatReview'])->name('masyarakat.review');
        Route::post('/masyarakat/{id}/review-process', [SuperAdminController::class, 'masyarakatReviewProcess'])->name('masyarakat.review-process');
        Route::get('/masyarakat/{id}', [SuperAdminController::class, 'masyarakatShow'])->name('masyarakat.show');

        Route::get('/bank-sampah', [SuperAdminController::class, 'bankSampahIndex'])->name('bank-sampah.index');
        Route::get('/bank-sampah/create', [SuperAdminController::class, 'bankSampahCreate'])->name('bank-sampah.create');
        Route::post('/bank-sampah', [SuperAdminController::class, 'bankSampahStore'])->name('bank-sampah.store');

        Route::get('/edukasi-superadmin', [ArtikelController::class, 'indexsuperadmin'])->name('edukasi-superadmin.index');
        Route::get('/edukasi/create', [ArtikelController::class, 'create'])->name('edukasi.create');
        Route::post('/edukasi', [ArtikelController::class, 'store'])->name('edukasi.store');
        Route::get('/edukasi/{id}', [ArtikelController::class, 'show'])->name('edukasi.show');
        Route::get('/edukasi/{id}/edit', [ArtikelController::class, 'edit'])->name('edukasi.edit');
        Route::put('/edukasi/{id}', [ArtikelController::class, 'update'])->name('edukasi.update');
        Route::delete('/edukasi/{id}', [ArtikelController::class, 'destroy'])->name('edukasi.destroy');

        Route::get('/pengaturan', [SettingController::class, 'index'])->name('pengaturan.index');
        Route::put('/pengaturan', [SettingController::class, 'update'])->name('pengaturan.update');
    });
});

Route::post('/register-user', [AuthController::class, 'registerUser'])->name('registerUser');
