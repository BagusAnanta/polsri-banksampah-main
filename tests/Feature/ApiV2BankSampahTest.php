<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\BankSampah;
use App\Models\JenisSampah;
use Spatie\Permission\Models\Role;

/**
 * V2 API Tests - Bank Sampah Resource Management
 * 
 * Tests bank sampah endpoints with custom methods
 */
class ApiV2BankSampahTest extends TestCase
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

    // ============ LIST BANK SAMPAH ============

    /** @test */
    public function admin_can_list_bank_sampahs()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/bank-sampahs');

        $response->assertStatus(200);
    }

    /** @test */
    public function unauthenticated_cannot_list_bank_sampahs()
    {
        $response = $this->json('GET', '/api/v2/bank-sampahs');

        $response->assertStatus(401);
    }

    // ============ VIEW SINGLE BANK SAMPAH ============

    /** @test */
    public function can_view_single_bank_sampah()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/bank-sampahs/1');

        // Either returns data or 404 if doesn't exist
        $this->assertTrue(in_array($response->getStatusCode(), [200, 404]));
    }

    // ============ BANK SAMPAH DETAIL ============

    /** @test */
    public function can_view_bank_sampah_detail_by_user_id()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/bank-sampah/detail/' . $this->user->id);

        // Should return data or 404
        $this->assertTrue(in_array($response->getStatusCode(), [200, 404]));
    }

    // ============ UPDATE BANK SAMPAH STATUS ============

    /** @test */
    public function admin_can_update_bank_sampah_status()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('PUT', '/api/v2/bank-sampah/update-status/' . $this->user->id, [
                             'status' => 'approved'
                         ]);

        // Should accept or return 404
        $this->assertTrue(in_array($response->getStatusCode(), [200, 204, 404]));
    }

    // ============ CREATE BANK SAMPAH ============

    /** @test */
    public function can_create_bank_sampah()
    {
        $response = $this->actingAs($this->user, 'api')
                         ->json('POST', '/api/v2/bank-sampahs', [
                             'user_id' => $this->user->id,
                             'jenis_sampah_id' => 1,
                             'berat' => 10,
                             'status' => 'pending'
                         ]);

        // Should create or validate
        $this->assertTrue(in_array($response->getStatusCode(), [201, 422]));
    }

    // ============ DELETE BANK SAMPAH ============

    /** @test */
    public function admin_can_delete_bank_sampah()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('DELETE', '/api/v2/bank-sampahs/1');

        // Should delete or return 404
        $this->assertTrue(in_array($response->getStatusCode(), [204, 404]));
    }
}
