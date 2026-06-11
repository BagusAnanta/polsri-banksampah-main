<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\UploadDocTicket;
use App\Models\UploadDocTrouble;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Mail\TicketAddedMail;
use App\Models\NotificationMail;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'Ticket';
        $data['tickets'] = Ticket::orderBy('created_at', 'desc')->get();
        return view('ticket.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Create Ticket';
        return view('ticket.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $loggedUser = auth()->user()->name;
        

        try {
            DB::beginTransaction();

            Ticket::create([
                'nomor_tiket' => $this->generateNumberTicket($loggedUser),
                'tanggal' => $request->tanggal,
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'status' => $request->status,
                'user_id' => auth()->user()->id
            ]);

            $ticket = Ticket::orderBy('created_at', 'desc')->first();
            // save doc multiple
            if ($request->hasFile('docs')) {
                foreach ($request->file('docs') as $file) {
                    $name = $file->getClientOriginalName();
                    $file->move(public_path() . '/doc_troubles/', $name);

                    $upload = new UploadDocTrouble();
                    $upload->ticket_id = $ticket->id;
                    $upload->user_id = $ticket->user_id;
                    $upload->file_upload = $name;
                    $upload->save();
                }

            }

            $lastTicket = Ticket::orderBy('created_at', 'desc')->first();
            $getMails = NotificationMail::all();
            foreach ($getMails as $mail) {
                Mail::to($mail->email)->send(new TicketAddedMail($lastTicket));
            }

            DB::commit(); 

            return redirect()->route('tickets.index')->with('success', 'Tiket berhasil dibuat');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('tickets.index')->with('failed', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        $data['page_title'] = 'Detail Ticket';
        $data['ticket'] = $ticket;
        return view('ticket.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        $data['page_title'] = 'Edit Ticket';
        $data['ticket'] = $ticket;
        return view('ticket.edit', $data);
    }

    public function updateTicket($id)
    {
        $data['page_title'] = 'Update Ticket';
        $data['ticket'] = Ticket::find($id);
        return view('ticket.update', $data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        try {
            $ticket->update([
                'tanggal' => $request->tanggal,
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'status' => $request->status,
                'user_id' => auth()->user()->id
            ]);
            return redirect()->route('tickets.index')->with('success', 'Tiket berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->route('tickets.index')->with('error', 'Tiket berhasil diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        try {
            $ticket->delete();
            return redirect()->route('tickets.index')->with('success', 'Tiket berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->route('tickets.index')->with('error', 'Tiket gagal dihapus');
        }
    }

    public function uploadDoc(Request $request, $id)
    {
        try {
            // save doc multiple
            if ($request->hasFile('docs')) {
                foreach ($request->file('docs') as $file) {
                    $name = $file->getClientOriginalName();
                    $file->move(public_path() . '/docs/', $name);

                    $upload = new UploadDocTicket();
                    $upload->ticket_id = $id;
                    $upload->user_id = auth()->user()->id;
                    $upload->file_upload = $name;
                    $upload->save();
                }

            }
            
            return response()->json(['message' => 'Upload success']);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }

    }

    public function deleteDoc(Request $request)
    {
        try {
            $upload = UploadDocTicket::where('ticket_id', $request->id)->where('id', $request->docId)->first();
            if ($upload) {
                // Build the full path to the file
                $filePath = public_path('docs/' . $upload->file_upload);
                
                // Check if the file exists and delete it
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
    
                // Delete the record from the database
                $upload->delete();
            }

            // return response
            return response()->json(['message' => 'Dokumen berhasil dihapus']);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }

    public function uploadDocTrouble(Request $request, $id)
    {
        try {
            // save doc multiple
            if ($request->hasFile('docs')) {
                foreach ($request->file('docs') as $file) {
                    $name = $file->getClientOriginalName();
                    $file->move(public_path() . '/doc_troubles/', $name);

                    $upload = new UploadDocTrouble();
                    $upload->ticket_id = $id;
                    $upload->user_id = auth()->user()->id;
                    $upload->file_upload = $name;
                    $upload->save();
                }

            }
            
            return response()->json(['message' => 'Upload success']);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }

    }

    public function deleteDocTrouble(Request $request)
    {
        try {
            $upload = UploadDocTrouble::where('ticket_id', $request->id)->where('id', $request->docId)->first();
            if ($upload) {
                // Build the full path to the file
                $filePath = public_path('doc_troubles/' . $upload->file_upload);
                
                // Check if the file exists and delete it
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
    
                // Delete the record from the database
                $upload->delete();
            }


            // return response
            return response()->json(['message' => 'Dokumen berhasil dihapus']);
        } catch (\Throwable $th) {
        }
    }

    public function updateStatus($id, Request $request)
    {
        try {
            $ticket = Ticket::find($id);
            $ticket->status = $request->status;
            $ticket->progress_by = $request->closed_by;
            $ticket->closed_by = $request->closed_by;
            $ticket->save();

            return redirect()->route('tickets.index')->with('success', 'Status berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->route('tickets.index')->with('error', 'Status berhasil diubah');
        }
    }

    public function generateNumberTicket($loggedUser)
    {
        $ticketCount = Ticket::count();
        $date = date('Ymd');
        $numDigits = max(4, strlen((string)($ticketCount + 1))); // Ensures at least 4 digits
        $nomor = 'TICKET-' . str_pad($ticketCount + 1, $numDigits, '0', STR_PAD_LEFT) . '-' . strtoupper($loggedUser) . '-' . $date;
        return $nomor;
    }

}
