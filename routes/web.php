<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\BankSampahController;
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
use App\Http\Controllers\MasyarakatController;
use App\Http\Controllers\BanksampahuserController;
use App\Http\Controllers\TiketsetorsampahController;
use App\Http\Controllers\TikettukarpoinController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\SettingController;
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


Route::get('/', function () {
    $data['page_title'] = "Login";
    return view('auth.login', $data);
})->name('user.login');

Route::middleware('auth:web')->group(function () {

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
    Route::patch('change-password', [UserController::class, 'changePassword'])->name('users.change-password');
    Route::resource('users', UserController::class);

    // Box Sampah
    Route::get('box-sampahs', [BoxSampahController::class, 'index'])->name('box-sampahs.index');
    Route::get('box-sampahs/create', [BoxSampahController::class, 'create'])->name('box-sampahs.create');
    Route::post('box-sampahs', [BoxSampahController::class, 'store'])->name('box-sampahs.store');
    Route::get('box-sampahs/show/{id}', [BoxSampahController::class, 'show'])->name('box-sampahs.show');
    Route::get('box-sampahs/edit/{id}', [BoxSampahController::class, 'edit'])->name('box-sampahs.edit');
    Route::put('box-sampahs/put/{id}', [BoxSampahController::class, 'update'])->name('box-sampahs.update');
    Route::delete('box-sampahs/delete/{id}', [BoxSampahController::class, 'destroy'])->name('box-sampahs.destroy');

    // Lapopran Pengaduan
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

Route::prefix('v2')->middleware('auth:web')->as('v2.')->group(function () {
    Route::resource('departements', DepartementController::class);
    Route::resource('tickets', TicketController::class);
    Route::resource('users', UserController::class);
    Route::resource('bank-sampahs', BankSampahController::class);
    Route::resource('box-sampahs', BoxSampahController::class);
    Route::resource('jenis-sampahs', JenisSampahController::class);
    Route::resource('laporan-pengaduans', LaporanPengaduanController::class);
    Route::resource('products-list', ListproductController::class);
    Route::resource('data-products', ProductController::class);
    Route::resource('notification-mails', NotificationMailController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('riwayat-setor', RiwayatSetorController::class);
    Route::resource('masyarakats', MasyarakatController::class);
    Route::resource('banksampahusers', BanksampahuserController::class);
    Route::resource('tiketsetorsampahs', TiketsetorsampahController::class);
    Route::resource('tikettukarpoin', TikettukarpoinController::class);
    Route::resource('artikels', ArtikelController::class);
    Route::resource('settings', SettingController::class);
    Route::resource('dashboard', DashboardController::class);
    Route::resource('monitoring', MonitoringController::class);
    Route::resource('transaksi', TransaksiController::class);
});

Route::post('/register-user', [UserController::class, 'registerUser'])->name('registerUser');
