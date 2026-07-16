<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Spatie\Permission\Models\Role;

class ApiProductTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $product;

    public function setUp(): void
    {
        parent::setUp();
        
        Role::create(['name' => 'admin']);
        
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
        
        $this->product = Product::factory()->create();
    }

    /** @test */
    public function can_list_products()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v1/data-products');

        $response->assertStatus(200);
    }

    /** @test */
    public function can_show_single_product()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v1/data-products/' . $this->product->id);

        $response->assertStatus(200);
    }

    /** @test */
    public function can_create_product_with_valid_data()
    {
        $productData = [
            'name' => 'Test Product',
            'description' => 'Product description',
            'price' => 50000,
            'stock' => 100,
        ];

        $response = $this->actingAs($this->admin, 'api')
                         ->json('POST', '/api/v1/data-products', $productData);

        $response->assertStatus(201);
    }

    /** @test */
    public function can_update_product()
    {
        $updateData = [
            'name' => 'Updated Product',
            'description' => 'Updated description',
            'price' => 75000,
            'stock' => 150,
        ];

        $response = $this->actingAs($this->admin, 'api')
                         ->json('PUT', '/api/v1/data-products/' . $this->product->id, $updateData);

        $response->assertStatus(200);
    }

    /** @test */
    public function can_delete_product()
    {
        $productToDelete = Product::factory()->create();

        $response = $this->actingAs($this->admin, 'api')
                         ->json('DELETE', '/api/v1/data-products/' . $productToDelete->id);

        $response->assertStatus(200);
    }

    /** @test */
    public function cannot_create_product_without_name()
    {
        $productData = [
            'description' => 'Product description',
            'price' => 50000,
        ];

        $response = $this->actingAs($this->admin, 'api')
                         ->json('POST', '/api/v1/data-products', $productData);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors('name');
    }

    /** @test */
    public function cannot_create_product_with_negative_price()
    {
        $productData = [
            'name' => 'Test Product',
            'description' => 'Product description',
            'price' => -10000,
            'stock' => 100,
        ];

        $response = $this->actingAs($this->admin, 'api')
                         ->json('POST', '/api/v1/data-products', $productData);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors('price');
    }
}
