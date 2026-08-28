<?php

namespace App\Http\Controllers;

use App\Models\TiketSetorSampah;
use App\Models\Masyarakat;
use App\Models\BankSampahUser;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\SetoranSampahBaru;
use App\Notifications\SetoranSampahStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TiketsetorsampahController extends Controller
{
    public function indexV2(Request $request)
    {
        $user = auth()->user();
        $masyarakat = Masyarakat::where('user_id', $user->id)->first();

        if (!$masyarakat) {
            return redirect()->route('login');
        }

        $tickets = TiketSetorSampah::where('masyarakat_id', $masyarakat->masyarakat_id)
            ->with(['bankSampahUser'])
            ->latest('created_at')
            ->get();

        $totalGramasi = $tickets->where('status', 'Selesai')->sum('berat_sampah_actual');

        $data['page_title'] = 'Tiket Setor Sampah';
        $data['tikets'] = $tickets;
        $data['totalGramasi'] = $totalGramasi;
        return view('v2.user.masyarakat.tiket-sampah-index', $data);
    }

    public function showV2(Request $request, $id)
    {
        $ticket = TiketSetorSampah::with(['masyarakat.user', 'bankSampahUser'])->findOrFail($id);

        $data['page_title'] = 'Detail Tiket Setor Sampah';
        $data['tiket'] = $ticket;
        return view('v2.user.masyarakat.tiket-sampah-show', $data);
    }

    public function cancel(Request $request, $id)
    {
        $ticket = TiketSetorSampah::findOrFail($id);
        
        if ($ticket->status !== 'Menunggu') {
            return back()->withErrors(['error' => 'Hanya tiket menunggu yang dapat dibatalkan']);
        }

        $ticket->status = 'Dibatalkan';
        $ticket->save();

        return back()->with('success', 'Tiket setor sampah berhasil dibatalkan!');
    }

    public function create()
    {
        $setting = Setting::first() ?? new Setting([
            'gram_per_point' => 1000,
            'point_per_voucher' => 500,
        ]);

        $data['page_title'] = 'Buat Tiket Setor Sampah';
        $data['banksampahusers'] = BankSampahUser::all();
        $data['gramPerPoint'] = $setting->gram_per_point;
        return view('v2.user.masyarakat.tiket-sampah-create', $data);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $masyarakat = Masyarakat::where('user_id', $user->id)->first();

        if (!$masyarakat) {
            return redirect()->route('login')->withErrors(['error' => 'Data masyarakat tidak ditemukan']);
        }

        $validated = $request->validate([
            'berat_sampah' => 'required|integer|min:1',
            'banksampah_id' => 'required|exists:banksampahusers,banksampah_id',
        ]);

        $setting = Setting::first() ?? new Setting([
            'gram_per_point' => 1000,
            'point_per_voucher' => 500,
        ]);
        
        $gramPerPoint = $setting->gram_per_point ?? 1000;
        $poin = floor($validated['berat_sampah'] / $gramPerPoint);

        $ticket = new TiketSetorSampah();
        $ticket->masyarakat_id = $masyarakat->masyarakat_id;
        $ticket->banksampah_id = $validated['banksampah_id'];
        $ticket->berat_sampah = $validated['berat_sampah'];
        $ticket->berat_sampah_actual = $validated['berat_sampah'];
        $ticket->poin = $poin;
        $ticket->qr_code_id = 'TS-' . strtoupper(Str::random(10));
        $ticket->status = 'Menunggu';
        $ticket->save();

        // in here, we gonna send notification to admin bank sampah that a new deposit ticket has been created
        $banksampahuseradmin = User::role('Admin Bank Sampah')->whereHas('admin_banksampah', function ($query) use ($validated) {
            $query->where('banksampah_id', $validated['banksampah_id']);
        })->first();

        // if user request for create tiket setor sampah, it will send notification into admin
        if ($banksampahuseradmin) {
            $banksampahuseradmin->notify(new SetoranSampahBaru($ticket));
        }

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Deposit ticket created successfully',
                'data' => $ticket
            ], 201);
        }

        return redirect()->route('tiket-sampah.index')->with('success', 'Tiket setor sampah berhasil dibuat!');
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
        return view('tiket-sampah.show', $data);
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

    public function adminIndex()
    {
        $user = auth()->user();
        $bankSampah = BankSampahUser::where('created_by', $user->id)->first();

        if (!$bankSampah) {
            return redirect()->route('login')->withErrors(['error' => 'Data bank sampah tidak ditemukan']);
        }

        $tikets = TiketSetorSampah::where('banksampah_id', $bankSampah->banksampah_id)
            ->with(['masyarakat.user'])
            ->latest('created_at')
            ->get();

        $totalTiket = $tikets->count();
        $menungguProses = $tikets->where('status', 'Menunggu')->count();
        $selesai = $tikets->where('status', 'Selesai')->count();

        $data = [
            'page_title' => 'Daftar Tiket Setoran Sampah',
            'tikets' => $tikets,
            'totalTiket' => $totalTiket,
            'menungguProses' => $menungguProses,
            'selesai' => $selesai,
        ];

        return view('v2.user.adminbanksampah.tiket-setor-index', $data);
    }

    public function adminShow($id)
    {
        $ticket = TiketSetorSampah::with(['masyarakat.user', 'bankSampahUser'])->findOrFail($id);
        $setting = Setting::first() ?? new Setting(['gram_per_point' => 1000, 'point_per_voucher' => 500]);

        $data = [
            'page_title' => 'Detail Tiket Setoran Sampah',
            'tiket' => $ticket,
            'gramPerPoint' => $setting->gram_per_point,
        ];

        return view('v2.user.adminbanksampah.tiket-setor-show', $data);
    }

    public function adminValidate(Request $request, $id)
    {
        $ticket = TiketSetorSampah::findOrFail($id);

        if ($ticket->status !== 'Menunggu') {
            return back()->withErrors(['error' => 'Tiket hanya dapat divalidasi jika status Menunggu']);
        }

        $validated = $request->validate([
            'berat_aktual' => 'required|integer|min:0',
        ]);

        $setting = Setting::first() ?? new Setting(['gram_per_point' => 1000]);
        $gramPerPoint = $setting->gram_per_point ?? 1000;
        $poin = floor($validated['berat_aktual'] / $gramPerPoint);

        $action = $request->input('action');


        if ($action === 'setuju') {
            $ticket->berat_sampah_actual = $validated['berat_aktual'];
            $ticket->poin = $poin;
            $ticket->status = 'Selesai';
            $ticket->save();

            $masyarakat = $ticket->masyarakat;
            $masyarakat->total_gramasi = ($masyarakat->total_gramasi ?? 0) + $validated['berat_aktual'];
            $masyarakat->poin = ($masyarakat->poin ?? 0) + $poin;
            $masyarakat->total_selesai = ($masyarakat->total_selesai ?? 0) + 1;
            $masyarakat->save();

            // prefer the direct relation if available, fallback to a safe whereHas lookup
            $masyarakatuser = User::role('Masyarakat')
                ->whereHas('masyarakat', function ($query) use ($masyarakat) {
                    $query->where('masyarakat_id', $masyarakat->masyarakat_id);
                })->first();


            if ($masyarakatuser) {
                $masyarakatuser->notify(new SetoranSampahStatus($ticket));
            }

            return back()->with('success', 'Tiket setoran sampah berhasil disetujui!');
        } elseif ($action === 'tolak') {
            $ticket->status = 'Ditolak';
            $ticket->save();

            $masyarakat = $ticket->masyarakat;

             // prefer the direct relation if available, fallback to a safe whereHas lookup
            $masyarakatuser = User::role('Masyarakat')
                ->whereHas('masyarakat', function ($query) use ($masyarakat) {
                    $query->where('masyarakat_id', $masyarakat->masyarakat_id);
                })->first();

            if ($masyarakatuser) {
                $masyarakatuser->notify(new SetoranSampahStatus($ticket));
            }

            return back()->with('success', 'Tiket setoran sampah berhasil ditolak!');
        }

        return back()->withErrors(['error' => 'Action tidak valid']);
    }

    public function adminScan()
    {
        $data = [
            'page_title' => 'Scan QR Tiket',
        ];

        return view('v2.user.adminbanksampah.qr-scan', $data);
    }
}
