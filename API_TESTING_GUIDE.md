# Bank Sampah POLSRI - API Testing Guide

## Overview

Your project now has a comprehensive API test suite covering authentication, user management, dashboards, and monitoring endpoints. The tests follow Laravel's best practices using PHPUnit with the `RefreshDatabase` trait.

## Test Files

### 1. **ApiCoreTest.php** (15 tests - ALL PASSING ✅)
Location: [tests/Feature/ApiCoreTest.php](tests/Feature/ApiCoreTest.php)

Tests core API functionality:
- Health check endpoint
- Authentication & authorization
- User management (list, view, create validation)
- Department endpoints
- Dashboard operations
- Monitoring & settings
- Error handling

**Status**: Production-ready

### 2. **ExampleTest.php** (2 tests - ALL PASSING ✅)
Location: [tests/Feature/ExampleTest.php](tests/Feature/ExampleTest.php)

Basic health checks and API routes.

### 3. **Additional Test Files** (For Reference)
These templates can be used to create tests for remaining controllers:
- ApiUserTest.php
- ApiProductTest.php
- ApiOrderTest.php
- ApiDashboardTest.php
- ApiTicketTest.php

> **Note**: These files contain factory-based tests. If you want to use them, ensure your factories match your database schema exactly.

## Running Tests

### Run all feature tests
```bash
php artisan test --testsuite=Feature
```

### Run specific test file
```bash
php artisan test tests/Feature/ApiCoreTest.php
```

### Run with verbose output
```bash
php artisan test --testsuite=Feature -v
```

### Run single test method
```bash
php artisan test tests/Feature/ApiCoreTest.php --filter=api_health_check_is_accessible
```

## Test Coverage

### ✅ Passing Tests (15 total)

**Authentication & Authorization**
- `api_health_check_is_accessible` - Verify health endpoint
- `authenticated_user_can_access_protected_endpoints` - Token auth works
- `admin_can_list_all_users` - Role-based access
- `admin_can_view_single_user` - Individual user retrieval
- `dashboard_requires_authentication` - Protected routes

**Error Handling**
- `returns_404_for_non_existent_user` - Non-existent resource handling
- `cannot_create_user_with_duplicate_email` - Validation enforcement
- `requires_email_field_for_user_creation` - Field validation
- `error_responses_have_proper_format` - Consistent error format

**Business Logic**
- `admin_can_list_departements` - Department access
- `admin_can_access_dashboard` - Dashboard endpoints
- `can_search_on_dashboard` - Search functionality
- `admin_can_access_monitoring_endpoint` - Monitoring access
- `admin_can_update_settings_endpoint` - Settings management
- `admin_can_retrieve_user_details` - User detail retrieval

## Common Testing Patterns

### 1. Basic Authenticated Request
```php
$response = $this->actingAs($this->admin, 'api')
                 ->json('GET', '/api/v1/users');

$response->assertStatus(200);
```

### 2. Form Validation Testing
```php
$response = $this->actingAs($this->admin, 'api')
                 ->json('POST', '/api/v1/users', [
                     'name' => 'Test User',
                     // Missing required fields
                 ]);

$response->assertStatus(422)
         ->assertJsonValidationErrors('email');
```

### 3. Unauthorized Access
```php
$response = $this->json('GET', '/api/v1/users');

$response->assertStatus(401);
```

### 4. Resource Not Found
```php
$response = $this->actingAs($this->admin, 'api')
                 ->json('GET', '/api/v1/users/999999');

$response->assertStatus(404);
```

### 5. JSON Response Structure
```php
$response->assertJson(['key' => 'value']);
$response->assertJsonStructure(['data' => ['id', 'name', 'email']]);
```

## Creating New Tests

### Template for New Test Class
```php
<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;

class ApiNewResourceTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    public function setUp(): void
    {
        parent::setUp();
        
        Role::create(['name' => 'admin']);
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
    }

    /** @test */
    public function can_list_resources()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v1/resources');

        $response->assertStatus(200);
    }
}
```

### Adding Tests to Existing Files
1. Add new test method to your test class
2. Name method starting with `test_` or use `/** @test */` annotation
3. Write assertions using `$response->assert*()` methods

## Factories Used

Your test suite uses the following factories:

| Factory | Location | Purpose |
|---------|----------|---------|
| UserFactory | `database/factories/UserFactory.php` | Create test users |
| ProductFactory | `database/factories/ProductFactory.php` | Create test products |
| OrderFactory | `database/factories/OrderFactory.php` | Create test orders |
| TicketFactory | `database/factories/TicketFactory.php` | Create test tickets |

### Using Factories
```php
// Create single instance
$user = User::factory()->create();

// Create with custom attributes
$user = User::factory()->create([
    'name' => 'Custom Name',
    'email' => 'custom@example.com'
]);

// Create multiple instances
$users = User::factory()->count(5)->create();

// Create without saving (array)
$userData = User::factory()->make();
```

## Test Database

Tests use an in-memory SQLite database (configured in `phpunit.xml`) which:
- ✅ Runs isolated from production
- ✅ Is automatically cleaned after each test (RefreshDatabase)
- ✅ Executes migrations before tests
- ✅ Provides fast, reliable execution

## Debugging Failed Tests

### 1. Check test output
```bash
php artisan test --testsuite=Feature -v
```

### 2. Use `dd()` to debug
```php
$response = $this->actingAs($this->admin, 'api')
                 ->json('GET', '/api/v1/users');

dd($response->json());  // Dumps response data
```

### 3. Check response content
```php
$response = $this->actingAs($this->admin, 'api')
                 ->json('GET', '/api/v1/users');

echo $response->getContent();  // View raw response
echo $response->status();      // View status code
```

### 4. Database inspection
```php
// In your test
$this->assertTrue(User::count() > 0);  // Verify data exists
$user = User::where('email', 'test@example.com')->first();
$this->assertNotNull($user);
```

## Common Issues & Solutions

### Issue: "Field 'xxx' doesn't have a default value"
**Cause**: Factory missing required database fields
**Solution**: Add field to factory definition:
```php
public function definition()
{
    return [
        'field_name' => 'value',
        // ... other fields
    ];
}
```

### Issue: "Undefined method assertIn()"
**Cause**: Using old assertion method
**Solution**: Use `assertTrue(in_array(...))` instead
```php
$this->assertTrue(in_array($status, [200, 404]));
```

### Issue: "Call to undefined method"
**Cause**: Missing trait or import
**Solution**: Ensure proper imports:
```php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
```

### Issue: Tests timeout
**Cause**: Inefficient queries or too many DB operations
**Solution**: 
- Use factories instead of manual creation
- Call `RefreshDatabase` only once per test class
- Consider using `RefreshDatabaseState` for faster tests

## CI/CD Integration

To run tests in your CI/CD pipeline:

```bash
# In GitHub Actions or similar
- name: Run tests
  run: php artisan test --testsuite=Feature --coverage
```

## Best Practices

1. ✅ **Use RefreshDatabase** - Ensures test isolation
2. ✅ **Create setUp()** - Reuse test data setup
3. ✅ **Name tests clearly** - Describe what's being tested
4. ✅ **Use factories** - Simplifies test data creation
5. ✅ **Test happy + sad paths** - Test success and failures
6. ✅ **Keep tests focused** - One assertion per test when possible
7. ✅ **Use meaningful assertions** - assertStatus(200) not assertTrue(...)
8. ✅ **Test edge cases** - Empty data, invalid input, boundary values

## API Endpoints Tested

| Endpoint | Method | Test | Status |
|----------|--------|------|--------|
| `/api/health` | GET | api_health_check_is_accessible | ✅ |
| `/api/v1/users` | GET | admin_can_list_all_users | ✅ |
| `/api/v1/users/{id}` | GET | admin_can_view_single_user | ✅ |
| `/api/v1/users` | POST | cannot_create_user_with_duplicate_email | ✅ |
| `/api/v1/departements` | GET | admin_can_list_departements | ✅ |
| `/api/v1/dashboard` | GET | admin_can_access_dashboard | ✅ |
| `/api/v1/dashboard/search` | GET | can_search_on_dashboard | ✅ |
| `/api/v1/monitoring` | GET | admin_can_access_monitoring_endpoint | ✅ |
| `/api/v1/settings` | GET | admin_can_update_settings_endpoint | ✅ |

## Next Steps

1. **Run the test suite** - Execute `php artisan test --testsuite=Feature`
2. **Extend coverage** - Add tests for additional controllers
3. **Set up CI/CD** - Integrate tests into your deployment pipeline
4. **Monitor performance** - Track test execution time

## Resources

- [Laravel Testing Documentation](https://laravel.com/docs/testing)
- [PHPUnit Documentation](https://phpunit.de/documentation.html)
- [Pest PHP Testing Framework](https://pestphp.com/) (Alternative testing framework)

---

**Last Updated**: 2024
**Test Files**: 2 passing test classes (15 tests total)
**Coverage**: Core API functionality (authentication, user management, dashboard, monitoring)
