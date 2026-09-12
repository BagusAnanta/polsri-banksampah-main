<?php

namespace App\Http\Controllers;

use App\Models\TiketTukarPoin;
use App\Models\TiketSetorSampah;
use App\Models\Masyarakat;
use App\Models\BankSampahUser;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\SetoranPoinBaru;
use App\Notifications\SetoranPoinStatus;
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

        // in here, we gonna send notification to admin bank sampah that a new deposit ticket has been created
        // it still same like for setor sampah before
        $banksampahuseradmin = User::role('Admin Bank Sampah')->whereHas('admin_banksampah', function ($query) use ($validated) {
            $query->where('banksampah_id', $validated['banksampah_id']);
        })->first();

        // if user request for create tiket setor sampah, it will send notification into admin
        if ($banksampahuseradmin) {
            $banksampahuseradmin->notify(new SetoranPoinBaru($ticket));
        }
        

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

    public function adminIndex()
    {
        $user = auth()->user();
        $bankSampah = BankSampahUser::where('created_by', $user->id)->first();

        if (!$bankSampah) {
            return redirect()->route('login')->withErrors(['error' => 'Data bank sampah tidak ditemukan']);
        }

        $tikets = TiketTukarPoin::where('banksampah_id', $bankSampah->banksampah_id)
            ->with(['masyarakat.user'])
            ->latest('created_at')
            ->get();

        $totalTiket = $tikets->count();
        $menungguProses = $tikets->where('status', 'Menunggu')->count();
        $selesai = $tikets->where('status', 'Selesai')->count();

        $data = [
            'page_title' => 'Daftar Tiket Penukaran Voucher',
            'tikets' => $tikets,
            'totalTiket' => $totalTiket,
            'menungguProses' => $menungguProses,
            'selesai' => $selesai,
        ];

        return view('v2.user.adminbanksampah.tiket-poin-index', $data);
    }

    public function adminShow($id)
    {
        $ticket = TiketTukarPoin::with(['masyarakat.user', 'bankSampahUser'])->findOrFail($id);

        $data = [
            'page_title' => 'Detail Tiket Penukaran Voucher',
            'tiket' => $ticket,
        ];

        return view('v2.user.adminbanksampah.tiket-poin-show', $data);
    }

    public function adminValidate(Request $request, $id)
    {
        $ticket = TiketTukarPoin::findOrFail($id);

        if ($ticket->status !== 'Menunggu') {
            return back()->withErrors(['error' => 'Tiket hanya dapat divalidasi jika status Menunggu']);
        }

        $action = $request->input('action');

        if ($action === 'setuju') {
            $ticket->status = 'Selesai';
            $ticket->save();

            $masyarakat = $ticket->masyarakat;
            $masyarakat->poin = ($masyarakat->poin ?? 0) - $ticket->poin;
            $masyarakat->voucher = ($masyarakat->voucher ?? 0) + 1;
            $masyarakat->save();

            // prefer the direct relation if available, fallback to a safe whereHas lookup
            $masyarakatuser = User::role('Masyarakat')
                ->whereHas('masyarakat', function ($query) use ($masyarakat) {
                    $query->where('masyarakat_id', $masyarakat->masyarakat_id);
                })->first();


            if ($masyarakatuser) {
                $masyarakatuser->notify(new SetoranPoinStatus($ticket));
            }

            return back()->with('success', 'Tiket penukaran voucher berhasil disetujui dan diterbitkan!');
        } elseif ($action === 'batalkan') {
            $ticket->status = 'Dibatalkan';
            $ticket->save();

            $masyarakat = $ticket->masyarakat;

             // prefer the direct relation if available, fallback to a safe whereHas lookup
            $masyarakatuser = User::role('Masyarakat')
                ->whereHas('masyarakat', function ($query) use ($masyarakat) {
                    $query->where('masyarakat_id', $masyarakat->masyarakat_id);
                })->first();

            if ($masyarakatuser) {
                $masyarakatuser->notify(new SetoranPoinStatus($ticket));
            }

            return back()->with('success', 'Tiket penukaran voucher berhasil dibatalkan!');
        }

        return back()->withErrors(['error' => 'Action tidak valid']);
    }
}
