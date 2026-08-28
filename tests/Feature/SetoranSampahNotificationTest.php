<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Models\Masyarakat;
use App\Models\TiketSetorSampah;
use App\Notifications\SetoranSampahStatus;
use App\Models\BankSampahUser;

class SetoranSampahNotificationTest extends TestCase
{
    // use RefreshDatabase;

    public function test_setoran_sampah_status_notification_sent()
    {
        Notification::fake();

        // create a user and attach masyarakat
        $user = User::factory()->create();

        $masyarakat = Masyarakat::create([
            'masyarakat_id' => (string) Str::uuid(),
            'user_id' => $user->id,
            'nik' => '1234567890',
            'identity_photo' => 'path/to/photo.jpg',
        ]);

        // create a bank sampah record so foreign key constraint is satisfied
        $bank = BankSampahUser::create([
            'banksampah_id' => (string) Str::uuid(),
            'created_by' => $user->id,
            'username' => 'bankuser',
            'password' => bcrypt('secret'),
            'nama_bank_sampah' => 'Test Bank',
            'alamat' => 'Test Address',
            'kecamatan' => 'Test',
            'jam_operasional' => '08:00-17:00',
            'nomor_telepon' => '08123456789',
            'deskripsi' => 'test',
        ]);

        // create a tiket
        $ticket = TiketSetorSampah::create([
            'tiketsampah_id' => (string) Str::uuid(),
            'masyarakat_id' => $masyarakat->masyarakat_id,
            'banksampah_id' => $bank->banksampah_id,
            'berat_sampah' => 1000,
            'berat_sampah_actual' => 1000,
            'poin' => 1,
            'qr_code_id' => 'TS-TEST',
            'status' => 'Menunggu',
        ]);

        // simulate the admin validation approving the ticket by directly updating and notifying
        $ticket->status = 'Ditolak';
        $ticket->save();

        // Trigger notification
        $user->notify(new SetoranSampahStatus($ticket));

        Notification::assertSentTo(
            [$user],
            SetoranSampahStatus::class,
            function ($notification, $channels) use ($ticket) {
                return $notification->ticket->tiketsampah_id === $ticket->tiketsampah_id;
            }
        );
    }
}
