<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\DepartementController;
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
use App\Http\Controllers\BanksampahuserController;
use App\Http\Controllers\TiketsetorsampahController;
use App\Http\Controllers\TikettukarpoinController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\SettingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/health', function () {
    return [
        'status' => 'ok',
        'timestamp' => now()->toIso8601String(),
    ];
})->name('health');

Route::post('/v1/register', [AuthController::class, 'register'])->name('api.v1.register');
Route::post('/v2/register', [AuthController::class, 'register'])->name('api.v2.register');
Route::post('/login', [AuthController::class, 'login'])->name('api.login');


Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
    Route::get('/profile', [AuthController::class, 'profile'])->name('api.profile');
    Route::patch('/change-password', [AuthController::class, 'changePassword'])->name('api.change-password');
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('v1')->as('v1.')->group(function () {
        Route::get('users', [AuthController::class, 'listUsers'])->name('users.index');
        Route::post('users', [AuthController::class, 'storeUser'])->name('users.store');
        Route::get('users/{user}', [AuthController::class, 'showUser'])->name('users.show');
        Route::put('users/{user}', [AuthController::class, 'updateUser'])->name('users.update');
        Route::delete('users/{user}', [AuthController::class, 'destroyUser'])->name('users.destroy');
        Route::apiResource('departements', DepartementController::class);
        Route::apiResource('tickets', TicketController::class);
        Route::apiResource('bank-sampahs', BankSampahController::class);
        Route::apiResource('box-sampahs', BoxSampahController::class);
        Route::apiResource('jenis-sampahs', JenisSampahController::class);
        Route::apiResource('laporan-pengaduans', LaporanPengaduanController::class);
        Route::apiResource('products-list', ListproductController::class);
        Route::apiResource('notification-mails', NotificationMailController::class);
        Route::apiResource('orders', OrderController::class);
        Route::apiResource('data-products', ProductController::class);
        Route::apiResource('riwayat-setors', RiwayatSetorController::class);
        Route::apiResource('masyarakats', AuthController::class);
        Route::apiResource('banksampahusers', BanksampahuserController::class);
        Route::apiResource('tiketsetorsampahs', TiketsetorsampahController::class);
        Route::apiResource('tikettukarpoin', TikettukarpoinController::class);
        Route::apiResource('artikels', ArtikelController::class);

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('dashboard/search', [DashboardController::class, 'search'])->name('dashboard.search');
        Route::get('setor/{id}', [DashboardController::class, 'getSetor'])->name('setor');

        Route::get('monitoring/sensor', [MonitoringController::class, 'index'])->name('monitoring.sensor');
        Route::get('monitoring/selenoid', [MonitoringController::class, 'selenoidControl'])->name('monitoring.selenoid');
        Route::post('monitoring/selenoid/send-status', [MonitoringController::class, 'changeStatusSelenoid'])->name('monitoring.change-status-selenoid');

        Route::patch('tickets/{id}/update-status', [TicketController::class, 'updateStatus'])->name('tickets.update-status');
        Route::post('tickets/{id}/upload', [TicketController::class, 'uploadDoc'])->name('tickets.upload-doc');
        Route::post('tickets/{id}/uploadDocTrouble', [TicketController::class, 'uploadDocTrouble'])->name('tickets.upload-doc-trouble');
        Route::post('tickets/document/delete/creator', [TicketController::class, 'deleteDoc'])->name('tickets.delete-document');
        Route::post('tickets/delete-doc-trouble', [TicketController::class, 'deleteDocTrouble'])->name('tickets.delete-doc-trouble');
        Route::get('laporan-pengaduans/show/{id}', [LaporanPengaduanController::class, 'showAdmin'])->name('laporan-pengaduans.showAdmin');
        Route::get('laporan-pengaduans/nasabah', [LaporanPengaduanController::class, 'indexNasabah'])->name('laporan-pengaduans.indexNasabah');
        Route::delete('laporan-pengaduans/deleteAdmin/{id}', [LaporanPengaduanController::class, 'destroyAdmin'])->name('laporan-pengaduans.destroyAdmin');
        Route::get('bank-sampah/detail/{user_id}', [BankSampahController::class, 'detail'])->name('bank-sampah.detail');
        Route::put('bank-sampah/update-status/{user_id}', [BankSampahController::class, 'updateStatus'])->name('bank-sampah.updateStatus');
        Route::get('admin/tabungan', [TransaksiController::class, 'adminIndex'])->name('transaksi.admin.index');
        Route::patch('transaksi/{id}/approve', [TransaksiController::class, 'approvedKredit'])->name('transaksi.approvedKredit');
        Route::post('transaksi/update', [TransaksiController::class, 'updateKredit'])->name('transaksi.updateKredit');
        Route::get('download-tabungan-pdf', [TransaksiController::class, 'tabunganPdf'])->name('download-tabungan-pdf');
        Route::get('download-nota-pdf', [TransaksiController::class, 'notaPdf'])->name('download-nota-pdf');
        Route::get('riwayat-setor/{month?}', [RiwayatSetorController::class, 'index'])->name('riwayat-setor');

        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings/{id?}', [SettingController::class, 'update'])->name('settings.update');
    });

    Route::prefix('v2')->as('v2.')->group(function () {
        Route::apiResource('users', AuthController::class);
        Route::apiResource('departements', DepartementController::class);
        Route::apiResource('tickets', TicketController::class);
        Route::apiResource('bank-sampahs', BankSampahController::class);
        Route::apiResource('box-sampahs', BoxSampahController::class);
        Route::apiResource('jenis-sampahs', JenisSampahController::class);
        Route::apiResource('laporan-pengaduans', LaporanPengaduanController::class);
        Route::apiResource('products-list', ListproductController::class);
        Route::apiResource('notification-mails', NotificationMailController::class);
        Route::apiResource('orders', OrderController::class);
        Route::apiResource('data-products', ProductController::class);
        Route::apiResource('riwayat-setors', RiwayatSetorController::class);
        Route::apiResource('masyarakats', AuthController::class);
        Route::apiResource('banksampahusers', BanksampahuserController::class);
        Route::apiResource('tiketsetorsampahs', TiketsetorsampahController::class);
        Route::apiResource('tikettukarpoin', TikettukarpoinController::class);
        Route::apiResource('artikels', ArtikelController::class);

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('dashboard/search', [DashboardController::class, 'search'])->name('dashboard.search');
        Route::get('setor/{id}', [DashboardController::class, 'getSetor'])->name('setor');

        Route::get('monitoring/sensor', [MonitoringController::class, 'index'])->name('monitoring.sensor');
        Route::get('monitoring/selenoid', [MonitoringController::class, 'selenoidControl'])->name('monitoring.selenoid');
        Route::post('monitoring/selenoid/send-status', [MonitoringController::class, 'changeStatusSelenoid'])->name('monitoring.change-status-selenoid');

        Route::patch('tickets/{id}/update-status', [TicketController::class, 'updateStatus'])->name('tickets.update-status');
        Route::post('tickets/{id}/upload', [TicketController::class, 'uploadDoc'])->name('tickets.upload-doc');
        Route::post('tickets/{id}/uploadDocTrouble', [TicketController::class, 'uploadDocTrouble'])->name('tickets.upload-doc-trouble');
        Route::post('tickets/document/delete/creator', [TicketController::class, 'deleteDoc'])->name('tickets.delete-document');
        Route::post('tickets/delete-doc-trouble', [TicketController::class, 'deleteDocTrouble'])->name('tickets.delete-doc-trouble');
        Route::get('laporan-pengaduans/show/{id}', [LaporanPengaduanController::class, 'showAdmin'])->name('laporan-pengaduans.showAdmin');
        Route::get('laporan-pengaduans/nasabah', [LaporanPengaduanController::class, 'indexNasabah'])->name('laporan-pengaduans.indexNasabah');
        Route::delete('laporan-pengaduans/deleteAdmin/{id}', [LaporanPengaduanController::class, 'destroyAdmin'])->name('laporan-pengaduans.destroyAdmin');
        Route::get('bank-sampah/detail/{user_id}', [BankSampahController::class, 'detail'])->name('bank-sampah.detail');
        Route::put('bank-sampah/update-status/{user_id}', [BankSampahController::class, 'updateStatus'])->name('bank-sampah.updateStatus');
        Route::get('admin/tabungan', [TransaksiController::class, 'adminIndex'])->name('transaksi.admin.index');
        Route::patch('transaksi/{id}/approve', [TransaksiController::class, 'approvedKredit'])->name('transaksi.approvedKredit');
        Route::post('transaksi/update', [TransaksiController::class, 'updateKredit'])->name('transaksi.updateKredit');
        Route::get('download-tabungan-pdf', [TransaksiController::class, 'tabunganPdf'])->name('download-tabungan-pdf');
        Route::get('download-nota-pdf', [TransaksiController::class, 'notaPdf'])->name('download-nota-pdf');
        Route::get('riwayat-setor/{month?}', [RiwayatSetorController::class, 'index'])->name('riwayat-setor');

        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings/{id?}', [SettingController::class, 'update'])->name('settings.update');
    });
});

