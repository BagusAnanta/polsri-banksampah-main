<?php

namespace App\Http\Controllers;

use App\Models\BankSampah;
use App\Models\JenisSampah;
use App\Models\Tabungan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BankSampahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // $data['penyetoranNasabah'] = BankSampah::all();
        // tampilkan nasabah yang masih memiliki setoran pending
        // Ambil data unik berdasarkan user_id dengan status pending
        // $data['penyetoranNasabah'] = BankSampah::with('user', 'jenisSampah')
        //     ->where('status', 'pending')
        //     ->groupBy('user_id')
        //     ->selectRaw('user_id, MAX(created_at) as created_at')
        //     ->get();

        // $data['penyetoranNasabah'] = BankSampah::with('user', 'jenisSampah')
        //     ->where('status', 'pending')
        //     ->select('user_id', DB::raw('MAX(status) as status'), DB::raw('MAX(tanggal_setor) as tanggal_setor'), DB::raw('MAX(created_at) as latest_created_at'))
        //     ->groupBy('user_id')
        //     ->get();

        // return view('bank-sampah.adminIndex', $data);

        // Query untuk mendapatkan penyetoranNasabah dengan status pending
        $query = BankSampah::with('user', 'jenisSampah')
            ->where('status', 'pending')
            ->select(
                'user_id',
                DB::raw('MAX(status) as status'),
                DB::raw('MAX(tanggal_setor) as tanggal_setor'),
                DB::raw('MAX(created_at) as latest_created_at')
            )
            ->groupBy('user_id');

        // Cek apakah ada parameter pencarian (search) di request
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('user_code', 'LIKE', "%$search%");
            });
        }

        $penyetoranNasabah = $query->paginate(10);

        return view('bank-sampah.adminIndex', compact('penyetoranNasabah'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['jenis_sampah'] = JenisSampah::orderBy('nama', 'asc')->get();
        return view('bank-sampah.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $totalDebit = 0; // Untuk menghitung total debit

            // Loop melalui setiap item qty yang dikirimkan
            foreach ($request->qty as $jenis_sampah_id => $jumlah) {
                if ($jumlah > 0) { // Pastikan hanya menyimpan jika jumlah lebih dari 0
                    // Ambil harga per jenis sampah
                    $jenisSampah = JenisSampah::findOrFail($jenis_sampah_id);
                    $subtotal = $jumlah * $jenisSampah->harga;

                    // Tambahkan subtotal ke total debit
                    $totalDebit += $subtotal;

                    BankSampah::updateOrCreate(
                        [
                            'jenis_sampah_id' => $jenis_sampah_id,
                            'user_id' => auth()->user()->id,
                            'tanggal_setor' => date('Y-m-d'),
                            'status' => 'pending'
                        ],
                        [
                            'qty' => $jumlah,
                        ]
                    );
                }
            }

            // $lastTabungan = Tabungan::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first();
            // if ($lastTabungan) {
            //     $sisa_saldo = $lastTabungan->sisa_saldo + $totalDebit;
            // } else {
            //     $sisa_saldo = $totalDebit;
            // }

            // // Ambil atau buat data tabungan untuk user saat ini
            // $tabungan = Tabungan::Create(
            //     [
            //         'bank_sampah_id' => BankSampah::where('user_id', auth()->user()->id)->latest()->first()->id,
            //         'user_id' => auth()->user()->id,
            //         'tanggal' => date('Y-m-d'),
            //         'debit' => $totalDebit,
            //         'kredit' => 0,
            //         'sisa_saldo' => $sisa_saldo
            //     ]
            // );

            // Update kolom debit dan sisa saldo
            // $tabungan->update([
            //     'debit' => $totalDebit,
            //     'sisa_saldo' => $tabungan->sisa_saldo + $totalDebit,
            // ]);

            // Redirect ke halaman lain atau menampilkan pesan sukses dan status setor pending
            if (Auth::user()->hasRole('Admin')) {
                return redirect()->route('bank_sampahs.index')->with('success', 'Setoran berhasil');
            } else {
                return redirect()->route('transaksi.index')->with('success', 'Penyetoran berhasil.');
            }
        } catch (\Throwable $th) {
            return back()->withErrors(['generalError', 'Terjadi kesalahan pada sistem, silahkan coba lagi!']);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BankSampah  $bankSampah
     * @return \Illuminate\Http\Response
     */
    public function show(BankSampah $bankSampah)
    {
        //
    }

    // public function approve($user_id)
    // {
    //     try {
    //         // Ambil semua data bank sampah dengan status pending untuk user tersebut
    //         $setoranPending = BankSampah::with('jenisSampah')->where('user_id', $user_id)
    //             ->where('status', 'pending')
    //             ->get();

    //         // Total debit untuk dihitung dan dimasukkan ke tabungan
    //         $totalDebit = 0;


    //         foreach ($setoranPending as $setoran) {
    //             $jenisSampah = $setoran->jenisSampah;
    //             $subtotal = $setoran->qty * $jenisSampah->harga;
    //             $totalDebit += $subtotal;

    //             // Ubah status menjadi approved
    //             $setoran->update(['status' => 'approved']);
    //         }

    //         $lastTabungan = Tabungan::where('user_id', $user_id)->orderBy('id', 'desc')->first();
    //         if ($lastTabungan) {
    //             $sisa_saldo = $lastTabungan->sisa_saldo + $totalDebit;
    //         } else {
    //             $sisa_saldo = $totalDebit;
    //         }

    //         // Masukkan data ke tabungan
    //         $tabungan = Tabungan::create([
    //             'user_id' => $user_id,
    //             'bank_sampah_id' => $setoranPending->first()->id,
    //             'tanggal' => now(),
    //             'debit' => $totalDebit,
    //             'kredit' => 0,
    //             'sisa_saldo' => $sisa_saldo,
    //             'status' => 'approved',
    //         ]);

    //         // Update kolom debit dan sisa saldo
    //         // $tabungan->update([
    //         //     'debit' => $totalDebit,
    //         //     'sisa_saldo' => $tabungan->sisa_saldo + $totalDebit,
    //         // ]);

    //         return redirect()->route('bank_sampahs.index')->with('success', 'Data setor berhasil diapprove dan dimasukkan ke tabungan nasabah.');
    //     } catch (\Throwable $th) {
    //         Log::error($th);
    //         return back()->withErrors(['generalError' => 'Terjadi kesalahan saat memproses approve.']);
    //     }
    // }

    public function detail($user_id)
    {
        $data['penyetoranNasabah'] = BankSampah::with('user', 'jenisSampah')->where('user_id', $user_id)
            ->where('status', 'pending')
            ->select('user_id', DB::raw('MAX(status) as status'), DB::raw('MAX(tanggal_setor) as tanggal_setor'), DB::raw('MAX(created_at) as latest_created_at'))
            ->groupBy('user_id')
            ->get();

        return view('bank-sampah.show', $data);
    }

    public function updateStatus(Request $request, $user_id)
    {
        try {
            // Validasi input
            $request->validate([
                'status' => 'required|in:pending,approved,gagal',
            ]);

            // Ambil semua data penyetoran dengan status pending
            $setoranPending = BankSampah::where('user_id', $user_id)
                ->where('status', 'pending')
                ->get();

            if ($request->status === 'approved') {
                // Proses approve seperti biasa
                $totalDebit = 0;
                foreach ($setoranPending as $setoran) {
                    $jenisSampah = $setoran->jenisSampah;
                    $subtotal = $setoran->qty * $jenisSampah->harga;
                    $totalDebit += $subtotal;
                    $setoran->update(['status' => 'approved']);
                }

                $lastTabungan = Tabungan::where('user_id', $user_id)->orderBy('id', 'desc')->first();
                $sisa_saldo = $lastTabungan ? $lastTabungan->sisa_saldo + $totalDebit : $totalDebit;

                Tabungan::create([
                    'user_id' => $user_id,
                    'bank_sampah_id' => $setoranPending->first()->id,
                    'tanggal' => now(),
                    'debit' => $totalDebit,
                    'kredit' => 0,
                    'sisa_saldo' => $sisa_saldo,
                    'status' => 'approved',
                ]);
            } elseif ($request->status === 'gagal') {
                // Ubah status penyetoran menjadi rejected
                foreach ($setoranPending as $setoran) {
                    $setoran->update(['status' => 'gagal']);
                }
            } else {
                // Ubah status penyetoran menjadi pending (jika diperlukan)
                foreach ($setoranPending as $setoran) {
                    $setoran->update(['status' => 'pending']);
                }
            }

            return redirect()->back()->with('success', 'Status berhasil diubah.');
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->withErrors(['generalError' => 'Terjadi kesalahan saat mengubah status.']);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BankSampah  $bankSampah
     * @return \Illuminate\Http\Response
     */
    public function edit(BankSampah $bankSampah)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BankSampah  $bankSampah
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BankSampah $bankSampah)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BankSampah  $bankSampah
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankSampah $bankSampah)
    {
        //
    }
}
