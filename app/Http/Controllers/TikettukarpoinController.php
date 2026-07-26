<?php

namespace App\Http\Controllers;

use App\Models\TiketTukarPoin;
use App\Models\TiketSetorSampah;
use App\Models\Masyarakat;
use App\Models\BankSampahUser;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TikettukarpoinController extends Controller
{
    public function indexV2(Request $request)
    {
        $user = auth()->user();
        $masyarakat = Masyarakat::where('user_id', $user->id)->first();

        if (!$masyarakat) {
            return redirect()->route('login');
        }

        $tickets = TiketTukarPoin::where('masyarakat_id', $masyarakat->masyarakat_id)
            ->with(['bankSampahUser'])
            ->latest('created_at')
            ->get();

        $totalPoinDeposit = TiketSetorSampah::where('masyarakat_id', $masyarakat->masyarakat_id)
            ->where('status', 'Selesai')
            ->sum('poin');

        $totalPoinRedeemed = TiketTukarPoin::where('masyarakat_id', $masyarakat->masyarakat_id)
            ->where('status', 'Selesai')
            ->sum('poin');

        $currentPoints = $totalPoinDeposit - $totalPoinRedeemed;

        $data['page_title'] = 'Tiket Tukar Poin';
        $data['tikets'] = $tickets;
        $data['totalGramasi'] = $currentPoints;
        return view('v2.user.masyarakat.tiket-poin-index', $data);
    }

    public function showV2(Request $request, $id)
    {
        $ticket = TiketTukarPoin::with(['masyarakat.user', 'bankSampahUser'])->findOrFail($id);

        $data['page_title'] = 'Detail Tiket Tukar Poin';
        $data['tiket'] = $ticket;
        return view('v2.user.masyarakat.tiket-poin-show', $data);
    }

    public function cancel(Request $request, $id)
    {
        $ticket = TiketTukarPoin::findOrFail($id);
        
        if ($ticket->status !== 'Menunggu') {
            return back()->withErrors(['error' => 'Hanya tiket menunggu yang dapat dibatalkan']);
        }

        $ticket->status = 'Dibatalkan';
        $ticket->save();

        return back()->with('success', 'Tiket tukar poin berhasil dibatalkan!');
    }

    public function create()
    {
        $user = auth()->user();
        $masyarakat = Masyarakat::where('user_id', $user->id)->first();

        if (!$masyarakat) {
            return redirect()->route('login');
        }

        $setting = Setting::first() ?? new Setting([
            'gram_per_point' => 1000,
            'point_per_voucher' => 500,
        ]);

        $totalPoinDeposit = TiketSetorSampah::where('masyarakat_id', $masyarakat->masyarakat_id)
            ->where('status', 'Selesai')
            ->sum('poin');

        $totalPoinRedeemed = TiketTukarPoin::where('masyarakat_id', $masyarakat->masyarakat_id)
            ->where('status', 'Selesai')
            ->sum('poin');

        $userCurrentPoints = $totalPoinDeposit - $totalPoinRedeemed;

        $banksampahusers = BankSampahUser::all();

        $data['page_title'] = 'Buat Tiket Tukar Poin';
        $data['banksampahusers'] = $banksampahusers;
        $data['userCurrentPoints'] = $userCurrentPoints;
        $data['pointPerVoucher'] = $setting->point_per_voucher;
        return view('v2.user.masyarakat.tiket-poin-create', $data);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $masyarakat = Masyarakat::where('user_id', $user->id)->first();

        if (!$masyarakat) {
            return redirect()->route('login')->withErrors(['error' => 'Data masyarakat tidak ditemukan']);
        }

        $validated = $request->validate([
            'poin' => 'required|integer|min:1',
            'banksampah_id' => 'required|exists:banksampahusers,banksampah_id',
        ]);

        $totalPoinDeposit = TiketSetorSampah::where('masyarakat_id', $masyarakat->masyarakat_id)
            ->where('status', 'Selesai')
            ->sum('poin');
        $totalPoinRedeemed = TiketTukarPoin::where('masyarakat_id', $masyarakat->masyarakat_id)
            ->where('status', 'Selesai')
            ->sum('poin');
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
        $ticket->masyarakat_id = $masyarakat->masyarakat_id;
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

        return redirect()->route('tiket-poin.index')->with('success', 'Tiket tukar poin berhasil dibuat!');
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
