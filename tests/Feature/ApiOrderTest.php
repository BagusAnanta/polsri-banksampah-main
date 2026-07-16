<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use Spatie\Permission\Models\Role;

class ApiOrderTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $user;
    protected $order;

    public function setUp(): void
    {
        parent::setUp();
        
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
        
        $this->user = User::factory()->create();
        $this->user->assignRole('user');
        
        $this->order = Order::factory()->create(['user_id' => $this->user->id]);
    }

    /** @test */
    public function admin_can_list_all_orders()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v1/orders');

        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_view_own_orders()
    {
        $response = $this->actingAs($this->user, 'api')
                         ->json('GET', '/api/v1/orders/' . $this->order->id);

        $response->assertStatus(200);
    }

    /** @test */
    public function can_create_order_with_valid_data()
    {
        $orderData = [
            'user_id' => $this->user->id,
            'total_price' => 250000,
            'status' => 'pending',
        ];

        $response = $this->actingAs($this->user, 'api')
                         ->json('POST', '/api/v1/orders', $orderData);

        $response->assertStatus(201);
    }

    /** @test */
    public function can_update_order_status()
    {
        $updateData = [
            'status' => 'completed',
        ];

        $response = $this->actingAs($this->admin, 'api')
                         ->json('PATCH', '/api/v1/orders/' . $this->order->id, $updateData);

        $response->assertStatus(200);
    }

    /** @test */
    public function can_delete_order()
    {
        $orderToDelete = Order::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->admin, 'api')
                         ->json('DELETE', '/api/v1/orders/' . $orderToDelete->id);

        $response->assertStatus(200);
    }

    /** @test */
    public function cannot_create_order_without_user_id()
    {
        $orderData = [
            'total_price' => 250000,
            'status' => 'pending',
        ];

        $response = $this->actingAs($this->user, 'api')
                         ->json('POST', '/api/v1/orders', $orderData);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors('user_id');
    }
}
