<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Ticket;
use Spatie\Permission\Models\Role;

class ApiTicketTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $user;
    protected $ticket;

    public function setUp(): void
    {
        parent::setUp();
        
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
        
        $this->user = User::factory()->create();
        $this->user->assignRole('user');
        
        $this->ticket = Ticket::factory()->create(['user_id' => $this->user->id]);
    }

    /** @test */
    public function can_list_tickets()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v1/tickets');

        $response->assertStatus(200);
    }

    /** @test */
    public function can_show_ticket_details()
    {
        $response = $this->actingAs($this->admin, 'api')
                         ->json('GET', '/api/v1/tickets/' . $this->ticket->id);

        $response->assertStatus(200);
    }

    /** @test */
    public function can_create_ticket_with_valid_data()
    {
        $ticketData = [
            'user_id' => $this->user->id,
            'title' => 'Support Ticket',
            'description' => 'Test ticket description',
            'category' => 'technical',
            'priority' => 'high',
        ];

        $response = $this->actingAs($this->user, 'api')
                         ->json('POST', '/api/v1/tickets', $ticketData);

        $response->assertStatus(201);
    }

    /** @test */
    public function can_update_ticket_status()
    {
        $updateData = [
            'status' => 'in_progress',
        ];

        $response = $this->actingAs($this->admin, 'api')
                         ->json('PATCH', '/api/v1/tickets/' . $this->ticket->id . '/update-status', $updateData);

        $response->assertStatus(200);
    }

    /** @test */
    public function can_upload_ticket_document()
    {
        $response = $this->actingAs($this->user, 'api')
                         ->post('/api/v1/tickets/' . $this->ticket->id . '/upload', [
                             'document' => \Illuminate\Http\UploadedFile::fake()->document('doc.pdf')
                         ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function can_delete_ticket()
    {
        $ticketToDelete = Ticket::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->admin, 'api')
                         ->json('DELETE', '/api/v1/tickets/' . $ticketToDelete->id);

        $response->assertStatus(200);
    }

    /** @test */
    public function cannot_create_ticket_without_title()
    {
        $ticketData = [
            'user_id' => $this->user->id,
            'description' => 'Test ticket description',
            'category' => 'technical',
        ];

        $response = $this->actingAs($this->user, 'api')
                         ->json('POST', '/api/v1/tickets', $ticketData);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors('title');
    }

    /** @test */
    public function unauthenticated_user_cannot_create_ticket()
    {
        $ticketData = [
            'user_id' => $this->user->id,
            'title' => 'Support Ticket',
            'description' => 'Test ticket description',
        ];

        $response = $this->json('POST', '/api/v1/tickets', $ticketData);

        $response->assertStatus(401);
    }
}
