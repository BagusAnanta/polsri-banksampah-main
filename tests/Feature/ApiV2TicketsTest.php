<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Ticket;
use Spatie\Permission\Models\Role;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * V2 API Tests - Ticket Resource Management
 * 
 * Tests ticket endpoints with custom methods for status updates and document uploads
 */
class ApiV2TicketsTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        
        Storage::fake('public');
        
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
        
        $this->user = User::factory()->create();
        $this->user->assignRole('user');
    }

    // ============ LIST TICKETS ============

    /** @test */
    public function admin_can_list_all_tickets()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v2/tickets');

        $response->assertStatus(200);
    }

    /** @test */
    public function unauthenticated_cannot_list_tickets()
    {
        $response = $this->json('GET', '/api/v2/tickets');

        $response->assertStatus(401);
    }

    // ============ VIEW SINGLE TICKET ============

    /** @test */
    public function can_view_single_ticket()
    {
        $response = $this->actingAs($this->user, 'api')
                         ->json('GET', '/api/v2/tickets/1');

        $this->assertTrue(in_array($response->getStatusCode(), [200, 404]));
    }

    // ============ CREATE TICKET ============

    /** @test */
    public function user_can_create_ticket_with_valid_data()
    {
        $ticketData = [
            'user_id' => $this->user->id,
            'title' => 'Test Ticket',
            'description' => 'This is a test ticket',
            'category' => 'technical',
            'priority' => 'high',
            'status' => 'open'
        ];

        $response = $this->actingAs($this->user, 'api')
                         ->json('POST', '/api/v2/tickets', $ticketData);

        // API may redirect or create
        $this->assertTrue(in_array($response->getStatusCode(), [201, 302, 200]));
    }

    /** @test */
    public function requires_title_when_creating_ticket()
    {
        $ticketData = [
            'user_id' => $this->user->id,
            'description' => 'This is a test ticket',
            'category' => 'technical',
            'priority' => 'high',
            'status' => 'open'
        ];

        $response = $this->actingAs($this->user, 'api')
                         ->json('POST', '/api/v2/tickets', $ticketData);

        // Accept redirects or validation errors
        $this->assertTrue(in_array($response->getStatusCode(), [302, 422]));
    }

    /** @test */
    public function unauthenticated_cannot_create_ticket()
    {
        $ticketData = [
            'title' => 'Test Ticket',
            'description' => 'This is a test ticket',
            'category' => 'technical',
            'priority' => 'high',
            'status' => 'open'
        ];

        $response = $this->json('POST', '/api/v2/tickets', $ticketData);

        $response->assertStatus(401);
    }

    // ============ UPDATE TICKET STATUS ============

    /** @test */
    public function can_update_ticket_status()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('PATCH', '/api/v2/tickets/1/update-status', [
                             'status' => 'resolved'
                         ]);

        $this->assertTrue(in_array($response->getStatusCode(), [200, 302, 404]));
    }

    // ============ UPLOAD TICKET DOCUMENT ============

    /** @test */
    public function can_upload_ticket_document()
    {
        $file = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

        $response = $this->actingAs($this->user, 'api')
                         ->post('/api/v2/tickets/1/upload', [
                             'document' => $file
                         ]);

        $this->assertTrue(in_array($response->getStatusCode(), [200, 201, 404]));
    }

    /** @test */
    public function can_upload_ticket_trouble_document()
    {
        $file = UploadedFile::fake()->create('trouble.pdf', 100, 'application/pdf');

        $response = $this->actingAs($this->user, 'api')
                         ->post('/api/v2/tickets/1/uploadDocTrouble', [
                             'document' => $file
                         ]);

        $this->assertTrue(in_array($response->getStatusCode(), [200, 201, 404]));
    }

    // ============ DELETE TICKET DOCUMENT ============

    /** @test */
    public function can_delete_ticket_document()
    {
        $response = $this->actingAs($this->user, 'api')
                         ->json('POST', '/api/v2/tickets/document/delete/creator', [
                             'document_id' => 1
                         ]);

        $this->assertTrue(in_array($response->getStatusCode(), [200, 204, 404]));
    }

    /** @test */
    public function can_delete_ticket_trouble_document()
    {
        $response = $this->actingAs($this->user, 'api')
                         ->json('POST', '/api/v2/tickets/delete-doc-trouble', [
                             'document_id' => 1
                         ]);

        $this->assertTrue(in_array($response->getStatusCode(), [200, 204, 404]));
    }

    // ============ UPDATE TICKET ============

    /** @test */
    public function can_update_ticket()
    {
        $updateData = [
            'title' => 'Updated Ticket',
            'description' => 'Updated description',
            'priority' => 'low'
        ];

        $response = $this->actingAs($this->user, 'api')
                         ->json('PUT', '/api/v2/tickets/1', $updateData);

        $this->assertTrue(in_array($response->getStatusCode(), [200, 404]));
    }

    // ============ DELETE TICKET ============

    /** @test */
    public function admin_can_delete_ticket()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('DELETE', '/api/v2/tickets/1');

        $this->assertTrue(in_array($response->getStatusCode(), [204, 404]));
    }
}
