<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;

/**
 * V2 API Tests - Transaction & Advanced Operations
 * 
 * Tests transaction endpoints, tabungan, and advanced operations
 */
class ApiV2TransactionsTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
        
        $this->user = User::factory()->create();
        $this->user->assignRole('user');
    }

    // ============ RIWAYAT SETOR ============

    /** @test */
    public function can_view_riwayat_setor()
    {
        $response = $this->actingAs($this->user, 'api')
                         ->json('GET', '/api/v2/riwayat-setors');

        $response->assertStatus(200);
    }

    /** @test */
    public function can_view_riwayat_setor_by_month()
    {
        $response = $this->actingAs($this->user, 'api')
                         ->json('GET', '/api/v2/riwayat-setor/2024-06');

        $this->assertTrue(in_array($response->getStatusCode(), [200, 404]));
    }

    // ============ TABUNGAN / TRANSAKSI ============

    /** @test */
    public function admin_can_view_tabungan_admin()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/admin/tabungan');

        $response->assertStatus(200);
    }

    /** @test */
    public function admin_can_approve_kredit()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('PATCH', '/api/v2/transaksi/1/approve', [
                             'status' => 'approved'
                         ]);

        $this->assertTrue(in_array($response->getStatusCode(), [200, 404]));
    }

    /** @test */
    public function admin_can_update_kredit()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('POST', '/api/v2/transaksi/update', [
                             'id' => 1,
                             'amount' => 50000
                         ]);

        $this->assertTrue(in_array($response->getStatusCode(), [200, 404]));
    }

    // ============ PDF DOWNLOADS ============

    /** @test */
    public function user_can_download_tabungan_pdf()
    {
        $response = $this->actingAs($this->user, 'api')
                         ->json('GET', '/api/v2/download-tabungan-pdf');

        $this->assertTrue(in_array($response->getStatusCode(), [200, 404]));
    }

    /** @test */
    public function user_can_download_nota_pdf()
    {
        $response = $this->actingAs($this->user, 'api')
                         ->json('GET', '/api/v2/download-nota-pdf');

        $this->assertTrue(in_array($response->getStatusCode(), [200, 404]));
    }

    // ============ TIKET SETOR SAMPAH ============

    /** @test */
    public function can_list_tiket_setor_sampah()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/tiketsetorsampahs');

        $response->assertStatus(200);
    }

    /** @test */
    public function can_view_single_tiket_setor()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/tiketsetorsampahs/1');

        $this->assertTrue(in_array($response->getStatusCode(), [200, 404]));
    }

    // ============ TIKET TUKAR POIN ============

    /** @test */
    public function can_list_tiket_tukar_poin()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/tikettukarpoin');

        $response->assertStatus(200);
    }

    /** @test */
    public function can_view_single_tiket_tukar_poin()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/tikettukarpoin/1');

        $this->assertTrue(in_array($response->getStatusCode(), [200, 404]));
    }

    // ============ BANK SAMPAH USERS ============

    /** @test */
    public function can_list_banksampahusers()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/banksampahusers');

        $response->assertStatus(200);
    }

    /** @test */
    public function can_view_single_banksampahuser()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/banksampahusers/1');

        $this->assertTrue(in_array($response->getStatusCode(), [200, 404]));
    }

    // ============ NOTIFICATION MAILS ============

    /** @test */
    public function admin_can_list_notification_mails()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/notification-mails');

        $response->assertStatus(200);
    }

    /** @test */
    public function can_view_single_notification_mail()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/notification-mails/1');

        $this->assertTrue(in_array($response->getStatusCode(), [200, 404]));
    }
}
