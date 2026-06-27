<?php

namespace App\Http\Controllers;

use App\Models\TiketSetorSampah;
use App\Models\Masyarakat;
use App\Models\BankSampahUser;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TiketsetorsampahController extends Controller
{
    public function index(Request $request)
    {
        $query = TiketSetorSampah::with(['masyarakat.user', 'bankSampahUser']);

        if ($request->has('masyarakat_id')) {
            $query->where('masyarakat_id', $request->get('masyarakat_id'));
        }
        if ($request->has('banksampah_id')) {
            $query->where('banksampah_id', $request->get('banksampah_id'));
        }
        if ($request->has('status')) {
            $query->where('status', $request->get('status'));
        }

        $tickets = $query->get();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $tickets
            ]);
        }

        $data['page_title'] = 'Tiket Setor Sampah';
        $data['tickets'] = $tickets;
        return view('tiketsetorsampahs.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Buat Tiket Setor Sampah';
        $data['masyarakats'] = Masyarakat::with('user')->get();
        $data['banksampahusers'] = BankSampahUser::all();
        return view('tiketsetorsampahs.create', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'masyarakat_id' => 'required|exists:masyarakats,masyarakat_id',
            'banksampah_id' => 'required|exists:banksampahusers,banksampah_id',
            'berat_sampah' => 'required|integer|min:1',
        ]);

        $setting = Setting::first();
        $gramPerPoint = ($setting && $setting->gram_per_point > 0) ? $setting->gram_per_point : 1000;
        
        $poin = floor($validated['berat_sampah'] / $gramPerPoint);

        $ticket = new TiketSetorSampah();
        $ticket->masyarakat_id = $validated['masyarakat_id'];
        $ticket->banksampah_id = $validated['banksampah_id'];
        $ticket->berat_sampah = $validated['berat_sampah'];
        $ticket->berat_sampah_actual = $validated['berat_sampah'];
        $ticket->poin = $poin;
        
        // what contain qrcode ? bro, the f*ck lah 
        // bro, keep it because we just get Id so its correct make like this, because we just get data based qr code id 
        $ticket->qr_code_id = 'TS-' . strtoupper(Str::random(10));
        $ticket->status = 'Menunggu';
        $ticket->save();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Deposit ticket created successfully',
                'data' => $ticket
            ], 201);
        }

        return redirect()->route('tiket-setor-sampah.index')->with('success', 'Tiket setor sampah berhasil dibuat!');
    }

    public function show(Request $request, $id)
    {
        $ticket = TiketSetorSampah::with(['masyarakat.user', 'bankSampahUser'])->findOrFail($id);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $ticket
            ]);
        }

        $data['page_title'] = 'Detail Tiket Setor';
        $data['ticket'] = $ticket;
        return view('tiketsetorsampahs.show', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Tiket Setor';
        $data['ticket'] = TiketSetorSampah::findOrFail($id);
        $data['banksampahusers'] = BankSampahUser::all();
        return view('tiketsetorsampahs.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $ticket = TiketSetorSampah::findOrFail($id);

        $validated = $request->validate([
            'berat_sampah_actual' => 'required|integer|min:0',
            'status' => 'required|in:Menunggu,Selesai',
        ]);

        $setting = Setting::first();
        $gramPerPoint = ($setting && $setting->gram_per_point > 0) ? $setting->gram_per_point : 1000;
        
        $poin = floor($validated['berat_sampah_actual'] / $gramPerPoint);

        $ticket->berat_sampah_actual = $validated['berat_sampah_actual'];
        $ticket->status = $validated['status'];
        $ticket->poin = $poin;
        $ticket->save();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Deposit ticket updated successfully',
                'data' => $ticket
            ]);
        }

        return redirect()->route('tiket-setor-sampah.show', $id)->with('success', 'Tiket setor sampah berhasil diupdate!');
    }

    public function destroy(Request $request, $id)
    {
        $ticket = TiketSetorSampah::findOrFail($id);
        $ticket->delete();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Deposit ticket deleted successfully'
            ]);
        }

        return redirect()->route('tiket-setor-sampah.index')->with('success', 'Tiket setor sampah berhasil dihapus!');
    }
}
