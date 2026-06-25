<?php

namespace App\Http\Controllers;

use App\Models\TiketTukarPoin;
use App\Models\TiketSetorSampah;
use App\Models\Masyarakat;
use App\Models\BankSampahUser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TikettukarpoinController extends Controller
{
    public function index(Request $request)
    {
        $query = TiketTukarPoin::with(['masyarakat.user', 'bankSampahUser']);

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

        $data['page_title'] = 'Tiket Tukar Poin';
        $data['tickets'] = $tickets;
        return view('tikettukarpoins.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Buat Tiket Tukar Poin';
        $data['masyarakats'] = Masyarakat::with('user')->get();
        $data['banksampahusers'] = BankSampahUser::all();
        return view('tikettukarpoins.create', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'masyarakat_id' => 'required|exists:masyarakats,masyarakat_id',
            'banksampah_id' => 'required|exists:banksampahusers,banksampah_id',
            'poin' => 'required|integer|min:1',
        ]);

        $masyarakatId = $validated['masyarakat_id'];
        $totalPoinDeposit = TiketSetorSampah::where('masyarakat_id', $masyarakatId)->where('status', 'Selesai')->sum('poin');
        $totalPoinRedeemed = TiketTukarPoin::where('masyarakat_id', $masyarakatId)->where('status', 'Selesai')->sum('poin');
        $pointsBalance = $totalPoinDeposit - $totalPoinRedeemed;

        if ($validated['poin'] > $pointsBalance) {
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Poin tidak mencukupi. Sisa poin Anda: ' . $pointsBalance
                ], 422);
            }
            return back()->withErrors(['poin' => 'Poin tidak mencukupi. Sisa poin Anda: ' . $pointsBalance]);
        }

        $ticket = new TiketTukarPoin();
        $ticket->masyarakat_id = $masyarakatId;
        $ticket->banksampah_id = $validated['banksampah_id'];
        $ticket->poin = $validated['poin'];
        $ticket->qr_code_id = 'TP-' . strtoupper(Str::random(10));
        $ticket->status = 'Menunggu';
        $ticket->save();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Redemption ticket created successfully',
                'data' => $ticket
            ], 201);
        }

        return redirect()->route('tiket-tukar-poin.index')->with('success', 'Tiket tukar poin berhasil dibuat!');
    }

    public function show(Request $request, $id)
    {
        $ticket = TiketTukarPoin::with(['masyarakat.user', 'bankSampahUser'])->findOrFail($id);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $ticket
            ]);
        }

        $data['page_title'] = 'Detail Tiket Tukar Poin';
        $data['ticket'] = $ticket;
        return view('tikettukarpoins.show', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Tiket Tukar Poin';
        $data['ticket'] = TiketTukarPoin::findOrFail($id);
        $data['banksampahusers'] = BankSampahUser::all();
        return view('tikettukarpoins.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $ticket = TiketTukarPoin::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:Menunggu,Selesai',
        ]);

        $ticket->status = $validated['status'];
        $ticket->save();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Redemption ticket updated successfully',
                'data' => $ticket
            ]);
        }

        return redirect()->route('tiket-tukar-poin.show', $id)->with('success', 'Tiket tukar poin berhasil diupdate!');
    }

    public function destroy(Request $request, $id)
    {
        $ticket = TiketTukarPoin::findOrFail($id);
        $ticket->delete();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Redemption ticket deleted successfully'
            ]);
        }

        return redirect()->route('tiket-tukar-poin.index')->with('success', 'Tiket tukar poin berhasil dihapus!');
    }
}
