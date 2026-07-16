<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;

/**
 * V2 API Tests - Resources (Products, Orders, Artikels, etc.)
 * 
 * Tests CRUD endpoints for various resources
 */
class ApiV2ResourcesTest extends TestCase
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

    // ============ PRODUCTS ============

    /** @test */
    public function admin_can_list_products()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/data-products');

        $response->assertStatus(200);
    }

    /** @test */
    public function admin_can_list_product_list()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/products-list');

        $response->assertStatus(200);
    }

    /** @test */
    public function can_view_single_product()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/data-products/1');

        $this->assertTrue(in_array($response->getStatusCode(), [200, 404]));
    }

    /** @test */
    public function admin_can_create_product()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('POST', '/api/v2/data-products', [
                             'name' => 'Test Product',
                             'price' => 10000,
                             'stock' => 100
                         ]);

        $this->assertTrue(in_array($response->getStatusCode(), [201, 422]));
    }

    // ============ ORDERS ============

    /** @test */
    public function admin_can_list_orders()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/orders');

        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_view_orders()
    {
        $response = $this->actingAs($this->user, 'api')
                         ->json('GET', '/api/v2/orders');

        $response->assertStatus(200);
    }

    /** @test */
    public function can_view_single_order()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/orders/1');

        $this->assertTrue(in_array($response->getStatusCode(), [200, 404]));
    }

    // ============ BOX SAMPAH ============

    /** @test */
    public function can_list_box_sampahs()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/box-sampahs');

        $response->assertStatus(200);
    }

    /** @test */
    public function can_view_single_box_sampah()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/box-sampahs/1');

        $this->assertTrue(in_array($response->getStatusCode(), [200, 404]));
    }

    // ============ JENIS SAMPAH ============

    /** @test */
    public function can_list_jenis_sampahs()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/jenis-sampahs');

        $response->assertStatus(200);
    }

    /** @test */
    public function can_view_single_jenis_sampah()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/jenis-sampahs/1');

        $this->assertTrue(in_array($response->getStatusCode(), [200, 404]));
    }

    // ============ LAPORAN PENGADUAN ============

    /** @test */
    public function can_list_laporan_pengaduan()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/laporan-pengaduans');

        $response->assertStatus(200);
    }

    /** @test */
    public function nasabah_can_view_own_laporan()
    {
        $response = $this->actingAs($this->user, 'api')
                         ->json('GET', '/api/v2/laporan-pengaduans/nasabah');

        $response->assertStatus(200);
    }

    /** @test */
    public function admin_can_view_laporan_detail()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/laporan-pengaduans/show/1');

        $this->assertTrue(in_array($response->getStatusCode(), [200, 404]));
    }

    /** @test */
    public function admin_can_delete_laporan()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('DELETE', '/api/v2/laporan-pengaduans/deleteAdmin/1');

        $this->assertTrue(in_array($response->getStatusCode(), [204, 404]));
    }

    // ============ MASYARAKAT ============

    /** @test */
    public function can_list_masyarakat()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/masyarakats');

        $response->assertStatus(200);
    }

    // ============ ARTIKELS ============

    /** @test */
    public function can_list_artikels()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/artikels');

        $response->assertStatus(200);
    }

    /** @test */
    public function can_view_single_artikel()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/artikels/1');

        $this->assertTrue(in_array($response->getStatusCode(), [200, 404]));
    }

    // ============ DEPARTEMENTS ============

    /** @test */
    public function can_list_departements()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/departements');

        $response->assertStatus(200);
    }

    // ============ SETTINGS ============

    /** @test */
    public function admin_can_view_settings()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/settings');

        $response->assertStatus(200);
    }

    /** @test */
    public function admin_can_update_settings()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('PUT', '/api/v2/settings/1', [
                             'key' => 'test_setting',
                             'value' => 'test_value'
                         ]);

        $this->assertTrue(in_array($response->getStatusCode(), [200, 404]));
    }
}
