<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;

/**
 * V2 API Tests - Dashboard & Monitoring Endpoints
 * 
 * Tests dashboard and monitoring endpoints
 */
class ApiV2DashboardAndMonitoringTest extends TestCase
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

    // ============ DASHBOARD ============

    /** @test */
    public function admin_can_access_dashboard()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/dashboard');

        $response->assertStatus(200);
    }

    /** @test */
    public function unauthenticated_cannot_access_dashboard()
    {
        $response = $this->json('GET', '/api/v2/dashboard');

        $response->assertStatus(401);
    }

    /** @test */
    public function can_search_dashboard_data()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/dashboard/search', [
                             'query' => 'test'
                         ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function can_get_setor_data_by_id()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/setor/1');

        $this->assertTrue(in_array($response->getStatusCode(), [200, 404]));
    }

    // ============ MONITORING - SENSOR ============

    /** @test */
    public function can_access_monitoring_sensor_data()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/monitoring/sensor');

        $response->assertStatus(200);
    }

    /** @test */
    public function unauthenticated_cannot_access_monitoring_sensor()
    {
        $response = $this->json('GET', '/api/v2/monitoring/sensor');

        $response->assertStatus(401);
    }

    // ============ MONITORING - SELENOID ============

    /** @test */
    public function can_access_selenoid_control()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/monitoring/selenoid');

        $response->assertStatus(200);
    }

    /** @test */
    public function admin_can_send_selenoid_status()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('POST', '/api/v2/monitoring/selenoid/send-status', [
                             'status' => 'on'
                         ]);

        $this->assertTrue(in_array($response->getStatusCode(), [200, 201, 422]));
    }

    /** @test */
    public function user_cannot_send_selenoid_status()
    {
        $response = $this->actingAs($this->user, 'api')
                         ->json('POST', '/api/v2/monitoring/selenoid/send-status', [
                             'status' => 'on'
                         ]);

        // Should be forbidden or unauthorized
        $this->assertTrue(in_array($response->getStatusCode(), [403, 401]));
    }
}
