<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tabungan;
use App\Models\BankSampah;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use PDF;

class TransaksiController extends Controller
{
    public function index()
    {
        $tabungan = Tabungan::with('bankSampah')
            ->whereHas('bankSampah', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->orderBy('id', 'asc')
            ->paginate(10);

        // $tabungan = Tabungan::where('user_id', auth()->user()->id)->get();

        // dd($tabungan);

        $firstTabungan = Tabungan::with('bankSampah')
            ->whereHas('bankSampah', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->orderBy('id', 'desc')
            ->first();

        $kreditNasabah = Tabungan::with('bankSampah')
            ->whereHas('bankSampah', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->orderBy('id', 'desc')
            ->latest()
            ->first() ?? new Tabungan();

        // $statusPendingPenyetoran = BankSampah::where('user_id', auth()->user()->id)->where('status', 'pending')->exists();
        $lastTabungan = BankSampah::where('user_id', auth()->id())->orderBy('id', 'desc')->first();
        // dd($lastTabungan);

        return view('transaksi.index', compact('tabungan', 'firstTabungan', 'kreditNasabah', 'lastTabungan'));
    }

    public function updateKredit(Request $request)
    {
        $request->validate([
            'tabungan_id' => 'required|exists:tabungans,id',
            'kredit' => 'required|numeric|min:0',
        ], [
            'tabungan_id.required' => 'Anda belum memiliki saldo untuk melakukan transaksi.'
        ]);

        // Ambil data tabungan berdasarkan ID
        $tabungan = Tabungan::find($request->tabungan_id);

        if ($request->kredit > $tabungan->sisa_saldo) {
            return back()->withErrors(['kredit' => 'Nominal kredit tidak boleh melebihi saldo yang tersedia.']);
        }

        // Tambahkan data baru ke tabel tabungan sebagai riwayat
        Tabungan::create([
            'bank_sampah_id' => $tabungan->bank_sampah_id, // ID bank sampah terkait
            'user_id' => Auth::user()->id, // ID user yang melakukan transaksi
            'tanggal' => now(),                            // Tanggal saat ini
            'debit' => $tabungan->sisa_saldo,                     // Debit dari sisa saldo terakhir
            'kredit' => $request->kredit,                  // Kredit dari input user
            'sisa_saldo' => $tabungan->sisa_saldo,                // Sisa saldo hasil pengurangan
            'status' => 'pending',
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Nominal kredit berhasil diajukan dan menunggu persetujuan admin.');
    }

    public function notaPdf(Request $request)
    {
        $request->validate([
            'tabungan_id' => 'required|exists:tabungans,id',
        ], [
            'tabungan_id.required' => 'Anda belum memiliki saldo untuk melakukan transaksi.'
        ]);

        function terbilang($angka)
        {
            $angka = abs($angka);
            $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
            $temp = "";

            if ($angka < 12) {
                $temp = " " . $huruf[$angka];
            } else if ($angka < 20) {
                $temp = terbilang($angka - 10) . " belas ";
            } else if ($angka < 100) {
                $temp = terbilang($angka / 10) . " puluh " . terbilang($angka % 10);
            } else if ($angka < 200) {
                $temp = " seratus " . terbilang($angka - 100);
            } else if ($angka < 1000) {
                $temp = terbilang($angka / 100) . " ratus " . terbilang($angka % 100);
            } else if ($angka < 2000) {
                $temp = " seribu " . terbilang($angka - 1000);
            } else if ($angka < 1000000) {
                $temp = terbilang($angka / 1000) . " ribu " . terbilang($angka % 1000);
            } else if ($angka < 1000000000) {
                $temp = terbilang($angka / 1000000) . " juta " . terbilang($angka % 1000000);
            } else if ($angka < 1000000000000) {
                $temp = terbilang($angka / 1000000000) . " miliar " . terbilang($angka % 1000000000);
            } else if ($angka < 1000000000000000) {
                $temp = terbilang($angka / 1000000000000) . " triliun " . terbilang($angka % 1000000000000);
            }

            return trim($temp);
        }

        $tabungan = Tabungan::findOrFail($request->tabungan_id);

        // Cari transaksi terakhir untuk bank sampah ini
        $lastTabungan = Tabungan::where('bank_sampah_id', $tabungan->bank_sampah_id)->where('user_id', Auth::user()->id)
            ->orderBy('tanggal', 'desc')
            ->latest()->first();

        $data['nominal'] = $request->nominal;

        $nominalTerbilang = terbilang($lastTabungan->kredit);

        $pdf = PDF::loadView('transaksi.pdf-nota', compact('data', 'lastTabungan', 'nominalTerbilang'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('nota-' . Auth::user()->name . '-waste-for-reward.pdf');
    }

    public function approvedKredit($id)
    {
        try {
            $tabungan = Tabungan::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['message' => 'Data tidak ditemukan']);
        }

        if ($tabungan->status !== 'pending') {
            return back()->withErrors(['message' => 'Transaksi sudah diproses.']);
        }

        $lastTabungan = Tabungan::where('bank_sampah_id', $tabungan->bank_sampah_id)
            ->where('user_id', $tabungan->user_id)
            ->where('status', 'approved')
            ->orderBy('id', 'desc')
            ->first();

        $debitTerakhir = $lastTabungan ? $lastTabungan->sisa_saldo : $tabungan->debit;
        $sisaSaldoBaru = $debitTerakhir - $tabungan->kredit;

        if ($sisaSaldoBaru < 0) {
            return back()->withErrors(['message' => 'Saldo tidak mencukupi pengurangan kredit']);
        }

        $tabungan->debit = $debitTerakhir;
        $tabungan->sisa_saldo = $sisaSaldoBaru;
        $tabungan->status = 'approved';
        $tabungan->save(); // Simpan data ke database

        return redirect()->route('transaksi.admin.index')->with('success', 'Transaksi berhasil disetujui.');
    }


    public function adminIndex(Request $request)
    {
        $query = Tabungan::where('kredit', '>', 0);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('user_code', 'ILIKE', "%$search%");
            });
        }

        $tabungan = $query->paginate(10);
        return view('transaksi.adminIndex', compact('tabungan'));
    }

    public function tabunganPdf(Request $request)
    {
        $request->validate([
            'tabungan_id' => 'required|exists:tabungans,id',
        ], [
            'tabungan_id.required' => 'Anda belum memiliki tabungan.'
        ]);

        $tabungan = Tabungan::with(['bankSampah', 'user'])
            ->whereHas('bankSampah', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->orderBy('tanggal', 'asc')
            ->get();

        $pdf = PDF::loadView('transaksi.pdf-tabungan', compact('tabungan'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('tabungan-' . Auth::user()->name . '-waste-for-reward.pdf');
    }
}
