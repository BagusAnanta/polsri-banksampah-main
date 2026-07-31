<?php

namespace App\Http\Controllers;

use App\Models\RiwayatSetor;
use App\Models\BankSampah;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class RiwayatSetorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($month = null)
    {
        $data['month'] = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        $month = $month ?? date('m');

        if (!isset($data['month'][$month])) {
            abort(404, 'Invalid month');
        }
        $year = date('Y');  // Mendapatkan tahun saat ini
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year); // Mendapatkan jumlah hari dalam bulan tersebut
        $latest = [];

        // Mengisi array $latest dengan data yang diambil dari metode getDataByDate
        for ($i = 1; $i <= $days; $i++) {
            $date = sprintf("%s-%02d-%02d", $year, $month, $i);
            $latest[$date] = $this->getDataByDate($date);
        }

        $latest = array_reverse($latest);
        $data['currentMonth'] = $latest;
        $data['period'] = $data['month'][$month] . ' ' . $year;
        return view('history.index', $data);
    }

    private function getDataByDate($date)
    {
        $data = BankSampah::with('jenisSampah')->where('tanggal_setor', $date)->where('user_id', auth()->user()->id)->get();

        $totalPrice = 0;

        // Loop through each entry and calculate the total using qty * jenisSampah->harga
        foreach ($data as $entry) {
            $totalPrice += $entry->qty * $entry->jenisSampah->harga; // Access 'harga' from related 'jenisSampah'
        }

        return [
            'entries' => $data,     // Data per hari
            'total' => $totalPrice  // Total harga per hari
        ];
    }

    public function slipPenyetoranBulanPdf(Request $request)
    {
    	
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

        $month = $request->input('month', date('m')); //default bulan saat ini
        $year = date('Y'); //Tahun saat ini

        $items = BankSampah::whereRaw('extract(month FROM CAST(tanggal_setor AS DATE)) = ?', [$month])
            ->whereRaw('extract(year FROM CAST(tanggal_setor AS DATE)) = ?', [$year])->where('user_id', auth()->user()->id)
            ->get();

        $totalHarga = $items->sum(function ($item) {
            return $item->jenisSampah->harga * $item->qty;
        });

        $totalHargaTerbilang = terbilang($totalHarga);


        $pdf = PDF::loadView('history.pdf-slip-penyetoran', compact('items', 'month', 'year', 'totalHarga', 'totalHargaTerbilang'));
        $pdf->setPaper('A4', 'landscape');
        $monthName = Carbon::createFromFormat('m', $month)->translatedFormat('F'); // Merubah angka bulan menjadi nama bulan
        return $pdf->stream('laporan-slip-penyetoran-' . $monthName . '-' . $year . '.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RiwayatSetor  $riwayatSetor
     * @return \Illuminate\Http\Response
     */
    public function show(RiwayatSetor $riwayatSetor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RiwayatSetor  $riwayatSetor
     * @return \Illuminate\Http\Response
     */
    public function edit(RiwayatSetor $riwayatSetor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RiwayatSetor  $riwayatSetor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RiwayatSetor $riwayatSetor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RiwayatSetor  $riwayatSetor
     * @return \Illuminate\Http\Response
     */
    public function destroy(RiwayatSetor $riwayatSetor)
    {
        //
    }
}
