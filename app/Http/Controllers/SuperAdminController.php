<?php

namespace App\Http\Controllers;

use App\Models\Masyarakat;
use App\Models\BankSampahUser;
use App\Models\Artikel;
use App\Models\Setting;
use App\Models\User;
use App\Models\TiketSetorSampah;
use App\Models\TiketTukarPoin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\MasyarakatVerificationMail;
use App\Notifications\MasyarakatApprove;
use Carbon\Carbon;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        $totalMasyarakat = Masyarakat::count();
        $menungguApproval = Masyarakat::where('verification', 'Menunggu')->count();
        $disetujui = Masyarakat::where('verification', 'Disetujui')->count();
        $ditolak = Masyarakat::where('verification', 'Ditolak')->count();
        $totalBankSampah = BankSampahUser::count();
        $totalArtikel = Artikel::count();

        $pendaftaranPerBulan = [];
        $bulanLabels = [];
        for ($i = 11; $i >= 0; $i--) {
            $bulan = now('Asia/Jakarta')->startOfMonth()->subMonths($i);
            $count = Masyarakat::whereYear('created_at', $bulan->year)
                ->whereMonth('created_at', $bulan->month)
                ->count();
            $pendaftaranPerBulan[] = $count;
            $bulanLabels[] = $bulan->format('M y');
        }

        $data = [
            'page_title' => 'Dashboard Super Admin',
            'totalMasyarakat' => $totalMasyarakat,
            'menungguApproval' => $menungguApproval,
            'disetujui' => $disetujui,
            'ditolak' => $ditolak,
            'totalBankSampah' => $totalBankSampah,
            'totalArtikel' => $totalArtikel,
            'pendaftaranPerBulan' => $pendaftaranPerBulan,
            'bulanLabels' => $bulanLabels,
        ];

        return view('v2.user.adminsuper.dashboard', $data);
    }

    public function masyarakatIndex()
    {
        $masyarakat = Masyarakat::with('user')->latest('created_at')->get();

        $totalMasyarakat = $masyarakat->count();
        $menungguPersetujuan = $masyarakat->where('verification', 'Menunggu')->count();
        $telahDisetujui = $masyarakat->where('verification', 'Disetujui')->count();

        $data = [
            'page_title' => 'Daftar Masyarakat',
            'masyarakat' => $masyarakat,
            'totalMasyarakat' => $totalMasyarakat,
            'menungguPersetujuan' => $menungguPersetujuan,
            'telahDisetujui' => $telahDisetujui,
        ];

        return view('v2.user.adminsuper.masyarakat-index', $data);
    }

    public function masyarakatShow($id)
    {
        $masyarakat = Masyarakat::with('user')->findOrFail($id);

        $data = [
            'page_title' => 'Profil Masyarakat',
            'masyarakat_nik' => $masyarakat->decrypted_nik,
            'masyarakat' => $masyarakat,
        ];

        return view('v2.user.adminsuper.masyarakat-profile', $data);
    }

    public function masyarakatReview($id)
    {
        $masyarakat = Masyarakat::with('user')->findOrFail($id);

        $data = [
            'page_title' => 'Peninjauan Pengajuan Akun Masyarakat',
            'masyarakat_nik' => $masyarakat->decrypted_nik,
            'masyarakat' => $masyarakat,
        ];

        return view('v2.user.adminsuper.masyarakat-review', $data);
    }

    public function masyarakatReviewProcess(Request $request, $id)
    {
        $masyarakat = Masyarakat::findOrFail($id);

        if ($masyarakat->verification !== 'Menunggu') {
            return back()->withErrors(['error' => 'Masyarakat hanya dapat diproses jika status Menunggu']);
        }

        $action = $request->input('action');

        if ($action === 'setuju') {
            $masyarakat->verification = 'Disetujui';
            $masyarakat->approved_by = Auth::id();
            $masyarakat->save();

            $this->sendVerificationEmail($masyarakat, 'Disetujui');

            // send notification for masyarakat with approve 
            // get masyarakat_id and shem them
            $masyarakatuser = User::role('Masyarakat')
                ->whereHas('masyarakat', function ($query) use ($masyarakat) {
                    $query->where('masyarakat_id', $masyarakat->masyarakat_id);
                })->first();


            if ($masyarakatuser) {
                $masyarakatuser->notify(new MasyarakatApprove($masyarakat));
            }

            return back()->with('success', 'Pendaftaran masyarakat berhasil disetujui dan email terkirim!');
        } elseif ($action === 'tolak') {
            $validated = $request->validate([
                'alasan_tolak' => 'nullable|string|max:500',
            ]);

            $masyarakat->verification = 'Ditolak';
            $masyarakat->save();

            $this->sendVerificationEmail($masyarakat, 'Ditolak', $validated['alasan_tolak'] ?? null);

            return back()->with('success', 'Pendaftaran masyarakat berhasil ditolak dan email terkirim!');
        }

        return back()->withErrors(['error' => 'Action tidak valid']);
    }

    private function sendVerificationEmail($masyarakat, $status, $alasan = null)
    {
        try {
            Mail::to($masyarakat->user->email)->send(new MasyarakatVerificationMail($masyarakat, $status, $alasan));
        } catch (\Throwable $th) {
            Log::warning('Gagal mengirim email verifikasi untuk masyarakat ' . $masyarakat->masyarakat_id . ': ' . $th->getMessage());
        }
    }

    public function bankSampahIndex()
    {
        $banks = BankSampahUser::with('creator')->latest('created_at')->get();
        $totalBankSampah = $banks->count();

        $data = [
            'page_title' => 'Daftar Bank Sampah',
            'banks' => $banks,
            'totalBankSampah' => $totalBankSampah,
        ];

        return view('v2.user.adminsuper.bank-sampah-index', $data);
    }

    public function bankSampahCreate()
    {
        $data = [
            'page_title' => 'Tambah Bank Sampah',
        ];

        return view('v2.user.adminsuper.bank-sampah-create', $data);
    }

    public function bankSampahStore(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|min:3|unique:banksampahusers,username',
            'password' => 'required|string|min:8',
            'nama_bank_sampah' => 'required|min:3|string',
            'alamat' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'kecamatan' => 'required|string',
            'jam_operasional' => 'required|string',
            'nomor_telepon' => 'nullable|string',
            'deskripsi' => 'nullable|string',
        ],[
            'username.required' => 'Username wajib diisi',
            'username.min' => 'Username minimal 3 karakter',
            'username.unique' => 'Username sudah terdaftar',

            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',

            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',

            'nama_bank_sampah.required' => 'Nama Bank Sampah wajib diisi',
            'nama_bank_sampah.min' => 'Nama Bank Sampah minimal 3 karakter',

            'alamat.required' => 'Alamat wajib diisi',
            'kecamatan.required' => 'Kecamatan wajib diisi',

            'jam_operasional.required' => 'Jam Operasional wajib diisi',
        ]);

        $user = new User();
        $user->name = $validated['nama_bank_sampah'];
        $user->username = $validated['username'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->registered_by = Auth::id();
        $user->user_code = 'BNKSMP' . str_pad($user->id, 6, '0', STR_PAD_LEFT);
        $user->save();

        $user->assignRole('Admin Bank Sampah');

        $bankSampah = new BankSampahUser();
        $bankSampah->created_by = $user->id;
        $bankSampah->username = $validated['username'];
        $bankSampah->password = Hash::make($validated['password']);
        $bankSampah->nama_bank_sampah = $validated['nama_bank_sampah'];
        $bankSampah->alamat = $validated['alamat'];
        $bankSampah->kecamatan = $validated['kecamatan'];
        $bankSampah->jam_operasional = $validated['jam_operasional'];
        $bankSampah->nomor_telepon = $validated['nomor_telepon'];
        $bankSampah->deskripsi = $validated['deskripsi'];
        $bankSampah->save();

        return redirect()->route('sa.bank-sampah.index')->with('success', 'Bank Sampah berhasil ditambahkan!');
    }
}
