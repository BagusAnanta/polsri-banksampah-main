<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JenisSampah;
use App\Models\BankSampah;
use App\Models\BoxSampah;
use App\Models\Tabungan;
use App\Models\Masyarakat;
use App\Models\TiketSetorSampah;
use App\Models\TiketTukarPoin;
use App\Models\Setting;
use App\Models\BankSampahUser;

class DashboardController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('permission:dashboard', ['only' => 'dashboard']);
    // }

    public function indexV2(Request $request)
    {
        $user = Auth::user();
        $masyarakat = Masyarakat::where('user_id', $user->id)->first();

        if (!$masyarakat) {
            return redirect()->route('login');
        }

        // get from database settings, if point per voucher is not set, use default value of 500
        // it same for gram per point, if not set, use default value of 1000
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

        $currentPoints = $totalPoinDeposit - $totalPoinRedeemed;

        $totalGramasi = TiketSetorSampah::where('masyarakat_id', $masyarakat->masyarakat_id)
            ->where('status', 'Selesai')
            ->sum('berat_sampah_actual');

        $setorSelesai = TiketSetorSampah::where('masyarakat_id', $masyarakat->masyarakat_id)
            ->where('status', 'Selesai')
            ->count();

        $poinPerBulan = [];
        $bulanLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = now()->subMonths($i);
            $bulanLabels[] = $bulan->translatedFormat('M');
            
            $poin = TiketSetorSampah::where('masyarakat_id', $masyarakat->masyarakat_id)
                ->where('status', 'Selesai')
                ->whereYear('updated_at', $bulan->year)
                ->whereMonth('updated_at', $bulan->month)
                ->sum('poin');
            
            $poinPerBulan[] = $poin;
        }

        $tiketSetorTerbaru = TiketSetorSampah::where('masyarakat_id', $masyarakat->masyarakat_id)
            ->with(['bankSampahUser'])
            ->latest('created_at')
            ->take(3)
            ->get();

        $tiketPoinTerbaru = TiketTukarPoin::where('masyarakat_id', $masyarakat->masyarakat_id)
            ->with(['bankSampahUser'])
            ->latest('created_at')
            ->take(3)
            ->get();

        $poinSaatIni = $currentPoints;
        $targetPoin = $setting->point_per_voucher;
        $persentase = $targetPoin > 0 ? min(round(($poinSaatIni / $targetPoin) * 100), 100) : 0;

        $siapDitukar = $poinSaatIni >= $targetPoin;
        $sisaPoin = max($targetPoin - $poinSaatIni, 0);

        $data = [
            'page_title' => 'Dashboard',
            'totalPoin' => $totalPoinDeposit,
            'totalGramasi' => $totalGramasi,
            'setorSelesai' => $setorSelesai,
            'poinSaatIni' => $poinSaatIni,
            'targetPoin' => $targetPoin,
            'poinPerBulan' => $poinPerBulan,
            'bulanLabels' => $bulanLabels,
            'tiketSetorTerbaru' => $tiketSetorTerbaru,
            'tiketPoinTerbaru' => $tiketPoinTerbaru,
            'persentase' => $persentase,
            'siapDitukar' => $siapDitukar,
            'sisaPoin' => $sisaPoin,
        ];

        return view('v2.user.masyarakat.dashboard', $data);
    }

    public function index(Request $request)
    {
        $data['page_title'] = 'Ticket List';

        $hour = date('H');
        if ($hour >= 5 && $hour < 12) {
            $greeting = "Selamat Pagi";
        } elseif ($hour >= 12 && $hour < 15) {
            $greeting = "Selamat Siang";
        } elseif ($hour >= 15 && $hour < 18) {
            $greeting = "Selamat Sore";
        } else {
            $greeting = "Selamat Malam";
        }

        $data['userTabungan'] = Auth::user();

        $lastTabungan = Tabungan::where('user_id', $data['userTabungan']->id)
            ->orderBy('id', 'desc')
            ->first();

        $data['tabunganData'] = $lastTabungan->sisa_saldo ?? 0;

        $data['users'] = User::orderBy('name', 'asc')->get();
        $data['jenis_sampah'] = JenisSampah::orderBy('nama', 'asc')->get();
        $data['greeting'] = $greeting;
        return view('dashboard.index', $data);
    }

    public function getRiwayat(Request $request){
        $user = Auth::user();
        $masyarakat = Masyarakat::where('user_id', $user->id)->first();

        if (!$masyarakat) {
            return redirect()->route('login');
        }

        $riwayat = collect();
        
        $selesaiSampah = TiketSetorSampah::where('masyarakat_id', $masyarakat->masyarakat_id)
            ->where('status', 'Selesai')
            ->with(['bankSampahUser'])
            ->latest('updated_at')
            ->get()
            ->map(function ($ticket) {
                return [
                    'type' => 'sampah',
                    'id' => $ticket->tiketsampah_id,
                    'nomor' => $ticket->tiketsampah_inc,
                    'status' => $ticket->status,
                    'bank_sampah' => $ticket->bankSampahUser->nama_bank_sampah ?? 'N/A',
                    'nilai' => number_format($ticket->berat_sampah_actual) . ' gram',
                    'tanggal' => $ticket->updated_at,
                    'created_at' => $ticket->created_at,
                ];
            });

        $selesaiPoin = TiketTukarPoin::where('masyarakat_id', $masyarakat->masyarakat_id)
            ->where('status', 'Selesai')
            ->with(['bankSampahUser'])
            ->latest('updated_at')
            ->get()
            ->map(function ($ticket) {
                return [
                    'type' => 'poin',
                    'id' => $ticket->tiketpoin_id,
                    'nomor' => $ticket->tiketpoin_inc,
                    'status' => $ticket->status,
                    'bank_sampah' => $ticket->bankSampahUser->nama_bank_sampah ?? 'N/A',
                    'nilai' => number_format($ticket->poin) . ' poin',
                    'tanggal' => $ticket->updated_at,
                    'created_at' => $ticket->created_at,
                ];
            });

        $riwayat = $selesaiSampah->concat($selesaiPoin)
            ->sortByDesc('tanggal')
            ->values();

        $data = [
            'page_title' => 'Riwayat Transaksi',
            'riwayat' => $riwayat,
        ];

        return view('v2.user.masyarakat.riwayat-index', $data);
    }

    public function search(Request $request){
        $query = User::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'ILIKE', "%{$search}%")
                ->orWhere('address', 'ILIKE', "%{$search}%");
        }

        $users = $query->get();

        return response()->json($users);
    }

    public function getSetor($id)
    {
        $data = BankSampah::where('user_id', $id)
            ->whereDate('tanggal_setor', Carbon::today())
            ->with('jenisSampah')
            ->orderBy('created_at', 'asc')
            ->get();

        $customSelect = $data->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->jenisSampah->nama,
                'qty' => $item->qty,
                'harga' => $item->jenisSampah->harga,
                'total' => $item->jenisSampah->harga * $item->qty,
                'tanggal_setor' => $item->tanggal_setor,
            ];
        });

        return response()->json($customSelect);
    }

    public function maps() {
        $data['box'] = BoxSampah::get();
        return view('dashboard.maps', $data);
    }

    public function adminBankSampahDashboard()
    {
        $user = Auth::user();
        $bankSampah = BankSampahUser::where('created_by', $user->id)->first();

        if (!$bankSampah) {
            return redirect()->route('login')->withErrors(['error' => 'Data bank sampah tidak ditemukan']);
        }

        $totalTiketSetor = TiketSetorSampah::where('banksampah_id', $bankSampah->banksampah_id)->count();
        $tiketSetorPending = TiketSetorSampah::where('banksampah_id', $bankSampah->banksampah_id)->where('status', 'Menunggu')->count();
        $tiketSetorSelesai = TiketSetorSampah::where('banksampah_id', $bankSampah->banksampah_id)->where('status', 'Selesai')->count();
        $tiketPoinPending = TiketTukarPoin::where('banksampah_id', $bankSampah->banksampah_id)->where('status', 'Menunggu')->count();

        $tiketSetorPendingList = TiketSetorSampah::where('banksampah_id', $bankSampah->banksampah_id)
            ->where('status', 'Menunggu')
            ->with('masyarakat.user')
            ->latest('created_at')
            ->take(5)
            ->get();

        $tiketPoinPendingList = TiketTukarPoin::where('banksampah_id', $bankSampah->banksampah_id)
            ->where('status', 'Menunggu')
            ->with('masyarakat.user')
            ->latest('created_at')
            ->take(5)
            ->get();

        $tiketPerBulan = ['selesai' => [], 'menunggu' => []];
        $bulanLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = now()->subMonths($i);
            $bulanLabels[] = $bulan->translatedFormat('M');

            $selesai = TiketSetorSampah::where('banksampah_id', $bankSampah->banksampah_id)
                ->where('status', 'Selesai')
                ->whereYear('updated_at', $bulan->year)
                ->whereMonth('updated_at', $bulan->month)
                ->count();

            $menunggu = TiketSetorSampah::where('banksampah_id', $bankSampah->banksampah_id)
                ->where('status', 'Menunggu')
                ->whereYear('created_at', $bulan->year)
                ->whereMonth('created_at', $bulan->month)
                ->count();

            $tiketPerBulan['selesai'][] = $selesai;
            $tiketPerBulan['menunggu'][] = $menunggu;
        }

        $data = [
            'page_title' => 'Dashboard Admin Bank Sampah',
            'totalTiketSetor' => $totalTiketSetor,
            'tiketSetorPending' => $tiketSetorPending,
            'tiketSetorSelesai' => $tiketSetorSelesai,
            'tiketPoinPending' => $tiketPoinPending,
            'tiketSetorPendingList' => $tiketSetorPendingList,
            'tiketPoinPendingList' => $tiketPoinPendingList,
            'tiketPerBulan' => $tiketPerBulan,
            'bulanLabels' => $bulanLabels,
            'bankInfo' => $bankSampah,
        ];

        return view('v2.user.adminbanksampah.dashboard', $data);
    }
}
