<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;

class ApiUserTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $admin;

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

    /** @test */
    public function can_list_users_when_authenticated()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v1/users');

        $response->assertStatus(200);
    }

    /** @test */
    public function cannot_list_users_without_authentication()
    {
        $response = $this->json('GET', '/api/v1/users');

        $response->assertStatus(401);
    }

    /** @test */
    public function can_show_single_user()
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
    public function can_create_user_with_valid_data()
    {
        $userData = [
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'role' => 'user',
            'no_rekening' => '1234567890',
            'bank' => 'BCA',
            'phone' => '08123456789',
            'alamat' => 'Jl. Test No. 123'
        ];

        $response = $this->actingAs($this->admin, 'api')
                         ->json('POST', '/api/v1/users', $userData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    /** @test */
    public function cannot_create_user_with_duplicate_email()
    {
        $userData = [
            'name' => 'Duplicate User',
            'username' => 'dupuser',
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
    public function can_update_user_with_valid_data()
    {
        $updateData = [
            'name' => 'Updated Name',
            'username' => 'updateduser',
            'email' => 'updated@example.com',
            'no_rekening' => '9876543210',
            'bank' => 'Mandiri',
            'phone' => '08987654321',
            'alamat' => 'Jl. Updated No. 456'
        ];

        $response = $this->actingAs($this->admin, 'api')
                         ->json('PUT', '/api/v1/users/' . $this->user->id, $updateData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => 'Updated Name'
        ]);
    }

    /** @test */
    public function can_delete_user()
    {
        $userToDelete = User::factory()->create();

        $response = $this->actingAs($this->admin, 'api')
                         ->json('DELETE', '/api/v1/users/' . $userToDelete->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('users', ['id' => $userToDelete->id]);
    }

    /** @test */
    public function cannot_delete_non_existent_user()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('DELETE', '/api/v1/users/999999');

        $response->assertStatus(404);
    }

    /** @test */
    public function requires_name_field_when_creating_user()
    {
        $userData = [
            'username' => 'noname',
            'email' => 'noname@example.com',
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
                 ->assertJsonValidationErrors('name');
    }

    /** @test */
    public function requires_email_field_when_creating_user()
    {
        $userData = [
            'name' => 'Test User',
            'username' => 'testuser',
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
}
