# API Testing Guide

This guide explains how to write and run tests for your Laravel API endpoints.

## Running Tests

### Run all tests
```bash
php artisan test
```

### Run only feature tests
```bash
php artisan test --testsuite=Feature
```

### Run only unit tests
```bash
php artisan test --testsuite=Unit
```

### Run a specific test file
```bash
php artisan test tests/Feature/ApiUserTest.php
```

### Run a specific test method
```bash
php artisan test tests/Feature/ApiUserTest.php --filter=can_list_users_when_authenticated
```

### Run tests with verbose output
```bash
php artisan test -v
```

### Run tests and show code coverage
```bash
php artisan test --coverage
```

---

## Test Files Created

### 1. **ApiUserTest.php** - User Management API
Tests for User CRUD operations:
- ✅ List users
- ✅ Show single user
- ✅ Create user
- ✅ Update user
- ✅ Delete user
- ✅ Validation errors
- ✅ Authorization

### 2. **ApiProductTest.php** - Product Management API
Tests for Product operations:
- ✅ List products
- ✅ Show product
- ✅ Create product
- ✅ Update product
- ✅ Delete product
- ✅ Validation (name, price, stock)

### 3. **ApiOrderTest.php** - Order Management API
Tests for Order operations:
- ✅ List orders
- ✅ Show order
- ✅ Create order
- ✅ Update order status
- ✅ Delete order
- ✅ Authorization checks

### 4. **ApiDashboardTest.php** - Dashboard API
Tests for Dashboard endpoints:
- ✅ Fetch dashboard data
- ✅ Search dashboard data
- ✅ Authentication required

### 5. **ApiTicketTest.php** - Ticket Management API
Tests for Ticket/Support operations:
- ✅ List tickets
- ✅ Show ticket
- ✅ Create ticket
- ✅ Update ticket status
- ✅ Upload documents
- ✅ Delete ticket

---

## Test Patterns Used

### Authentication Pattern
```php
$response = $this->actingAs($user, 'api')
                 ->json('GET', '/api/v1/users');
```

### POST/Create Pattern
```php
$response = $this->actingAs($admin, 'api')
                 ->json('POST', '/api/v1/users', $userData);

$response->assertStatus(201);
```

### Validation Testing Pattern
```php
$response = $this->actingAs($user, 'api')
                 ->json('POST', '/api/v1/users', $invalidData);

$response->assertStatus(422)
         ->assertJsonValidationErrors('email');
```

### Authorization Pattern
```php
$response = $this->json('GET', '/api/v1/users');
$response->assertStatus(401); // Unauthenticated
```

---

## Common Assertions

```php
// Status codes
$response->assertStatus(200);
$response->assertStatus(201); // Created
$response->assertStatus(400); // Bad Request
$response->assertStatus(401); // Unauthorized
$response->assertStatus(404); // Not Found
$response->assertStatus(422); // Validation Error
$response->assertStatus(500); // Server Error

// JSON assertions
$response->assertJson(['key' => 'value']);
$response->assertJsonStructure(['data' => ['id', 'name']]);
$response->assertJsonValidationErrors('email');
$response->assertJsonCount(5);

// Database assertions
$this->assertDatabaseHas('users', ['email' => 'test@example.com']);
$this->assertDatabaseMissing('users', ['id' => 999]);
$this->assertDatabaseCount('users', 10);
```

---

## Creating New Tests

### 1. Create a new test file
```bash
php artisan make:test Feature/ApiMyResourceTest
```

### 2. Basic test structure
```php
<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;

class ApiMyResourceTest extends TestCase
{
    use RefreshDatabase; // Reset database for each test

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

    /** @test */
    public function can_list_resources()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v1/resources');

        $response->assertStatus(200);
    }

    /** @test */
    public function cannot_access_without_authentication()
    {
        $response = $this->json('GET', '/api/v1/resources');

        $response->assertStatus(401);
    }
}
```

---

## RefreshDatabase Trait

The `RefreshDatabase` trait ensures:
- ✅ Database is reset before each test
- ✅ No test data interferes with other tests
- ✅ Clean state for testing

Without it, tests will modify your actual database!

```php
use Illuminate\Foundation\Testing\RefreshDatabase;

class MyTest extends TestCase
{
    use RefreshDatabase; // Always use this!
}
```

---

## Factories for Test Data

Create factories for models:

```bash
php artisan make:factory UserFactory
php artisan make:factory ProductFactory
php artisan make:factory OrderFactory
```

Use in tests:
```php
$user = User::factory()->create();
$product = Product::factory()->count(5)->create();
```

---

## Testing File Uploads

```php
/** @test */
public function can_upload_file()
{
    $response = $this->actingAs($this->user, 'api')
                     ->post('/api/v1/upload', [
                         'file' => \Illuminate\Http\UploadedFile::fake()
                                     ->image('avatar.jpg')
                     ]);

    $response->assertStatus(200);
}
```

---

## Expected Test Results

When you run `php artisan test`, you should see:

```
   PASS  Tests\Feature\ExampleTest
  ✓ health endpoint returns
  ✓ authentication api user route

   PASS  Tests\Feature\ApiUserTest
  ✓ can list users when authenticated
  ✓ cannot list users without authentication
  ✓ can show single user
  ✓ can create user with valid data
  ... and more

Tests:  45 passed (123.45s)
```

---

## Troubleshooting

### Test fails with "Undefined array key"
Ensure you're using `RefreshDatabase` and creating test data properly.

### "401 Unauthorized" errors
Check that you're using `$this->actingAs($user, 'api')` for API tests.

### Validation errors not working
Ensure your route uses `api` middleware and returns JSON on validation errors.

### "SQLSTATE[HY000]" database errors
This usually means required fields are missing. Check your factory definitions.

---

## Next Steps

1. ✅ Run existing tests: `php artisan test`
2. ✅ Create tests for remaining controllers
3. ✅ Test edge cases and error scenarios
4. ✅ Aim for 80%+ code coverage
5. ✅ Run tests in CI/CD pipeline
