<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;

class ApiDashboardTest extends TestCase
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

    /** @test */
    public function can_fetch_dashboard_data()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v1/dashboard');

        $response->assertStatus(200);
    }

    /** @test */
    public function can_search_dashboard_data()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v1/dashboard/search', ['query' => 'test']);

        $response->assertStatus(200);
    }

    /** @test */
    public function unauthenticated_user_cannot_access_dashboard()
    {
        $response = $this->json('GET', '/api/v1/dashboard');

        $response->assertStatus(401);
    }

    /** @test */
    public function can_get_setor_data_by_id()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v1/setor/1');

        // May return 404 if data doesn't exist, but shouldn't fail auth
        $this->assertTrue(
            in_array($response->getStatusCode(), [200, 404]),
            "Expected status 200 or 404, got {$response->getStatusCode()}"
        );
    }
}
