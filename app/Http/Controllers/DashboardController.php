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

class DashboardController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('permission:dashboard', ['only' => 'dashboard']);
    // }

    public function index(Request $request)
    {
        $data['page_title'] = 'Ticket List';

        $hour = date('H'); // Mendapatkan jam dalam format 24 jam (00-23)
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
        // dd($lastTabungan);
        // dd($userData);

        $data['users'] = User::orderBy('name', 'asc')->get();
        $data['jenis_sampah'] = JenisSampah::orderBy('nama', 'asc')->get();
        $data['greeting'] = $greeting;
        return view('dashboard.index', $data);
    }

    public function search(Request $request)
    {
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
}
