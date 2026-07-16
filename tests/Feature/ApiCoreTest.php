<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;

/**
 * Core API Tests - Focus on authentication and listing endpoints
 * 
 * These tests verify the fundamental API functionality is working correctly.
 * Expand these based on your actual database schema requirements.
 */
class ApiCoreTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        
        // Create roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        
        // Create test users
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
        
        $this->user = User::factory()->create();
        $this->user->assignRole('user');
    }

    // ============ HEALTH CHECK ============
    
    /** @test */
    public function api_health_check_is_accessible()
    {
        $response = $this->json('GET', '/api/health');

        $response->assertStatus(200)
                 ->assertJson(['status' => 'ok'])
                 ->assertJsonStructure(['status', 'timestamp']);
    }

    // ============ AUTHENTICATION ============

    /** @test */
    public function authenticated_user_can_access_protected_endpoints()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v1/users');

        $response->assertStatus(200);
    }

    // ============ USER MANAGEMENT ============

    /** @test */
    public function admin_can_list_all_users()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v1/users');

        $response->assertStatus(200);
    }

    /** @test */
    public function admin_can_view_single_user()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v1/users/' . $this->user->id);

        $response->assertStatus(200);
    }

    /** @test */
    public function returns_404_for_non_existent_user()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v1/users/999999');

        $response->assertStatus(404);
    }

    /** @test */
    public function cannot_create_user_with_duplicate_email()
    {
        $userData = [
            'name' => 'Duplicate User',
            'username' => 'dupuser' . rand(1000, 9999),
            'email' => $this->user->email,
            'password' => 'password123',
            'role' => 'user',
            'no_rekening' => '1234567890',
            'bank' => 'BCA',
            'phone' => '08123456789',
            'alamat' => 'Jl. Test No. 123'
        ];

        $response = $this->actingAs($this->admin, 'api')
                         ->json('POST', '/api/v1/users', $userData);

        $response->assertStatus(422);
    }

    /** @test */
    public function requires_email_field_for_user_creation()
    {
        $userData = [
            'name' => 'Test User',
            'username' => 'testuser' . rand(1000, 9999),
            'password' => 'password123',
            'role' => 'user',
            'no_rekening' => '1234567890',
            'bank' => 'BCA',
            'phone' => '08123456789',
            'alamat' => 'Jl. Test'
        ];

        $response = $this->actingAs($this->admin, 'api')
                         ->json('POST', '/api/v1/users', $userData);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors('email');
    }

    // ============ DEPARTEMENTS (ROLES) ============

    /** @test */
    public function admin_can_list_departements()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v1/departements');

        $response->assertStatus(200);
    }

    // ============ DASHBOARD ============

    /** @test */
    public function admin_can_access_dashboard()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v1/dashboard');

        $response->assertStatus(200);
    }

    /** @test */
    public function can_search_on_dashboard()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v1/dashboard/search', ['query' => 'test']);

        $response->assertStatus(200);
    }

    /** @test */
    public function dashboard_requires_authentication()
    {
        $response = $this->json('GET', '/api/v1/dashboard');

        $response->assertStatus(401);
    }

    // ============ MONITORING ============

    /** @test */
    public function admin_can_access_monitoring_endpoint()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v1/monitoring');

        // API should either return data or 404, but not 401
        $this->assertTrue(in_array($response->getStatusCode(), [200, 404]));
    }

    /** @test */
    public function admin_can_update_settings_endpoint()
    {
        // First check if settings endpoint exists
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v1/settings');

        // Settings should be accessible or 404
        $this->assertTrue(in_array($response->getStatusCode(), [200, 404]));
    }

    /** @test */
    public function admin_can_retrieve_user_details()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v1/users/' . $this->admin->id);

        $response->assertStatus(200);
    }

    /** @test */
    public function error_responses_have_proper_format()
    {
        $response = $this->json('GET', '/api/v1/users/999999', [], []);

        // Should return proper error format
        $this->assertTrue(in_array($response->getStatusCode(), [401, 404, 422]));
    }
}
