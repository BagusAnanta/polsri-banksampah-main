<?php

namespace App\Http\Controllers;

use App\Models\BoxSampah;
use App\Models\LaporanPengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanPengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $laporans = LaporanPengaduan::with('boxSampah', 'user')->get();
        return view('laporan-pengaduan.index', compact('laporans'));
    }

    public function indexNasabah()
    {
        $laporans = LaporanPengaduan::with('boxSampah', 'user')->where('user_id', Auth::id())->get();
        return view('laporan-pengaduan.indexNasabah', compact('laporans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $boxSampahs = BoxSampah::all();
        return view('laporan-pengaduan.create', compact('boxSampahs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'box_sampah_id' => 'required|exists:box_sampahs,id',
            'catatan' => 'required|string',
        ]);

        LaporanPengaduan::create([
            'box_sampah_id' => $request->box_sampah_id,
            'user_id' => Auth::id(),
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('laporan-pengaduans.indexNasabah')->with('success', 'Laporan pengaduan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $laporan = LaporanPengaduan::with('boxSampah', 'user')->where('user_id', Auth::id())->find($id);
        return view('laporan-pengaduan.show', compact('laporan'));
    }

    public function showAdmin($id)
    {
        $laporan = LaporanPengaduan::with('boxSampah', 'user')->find($id);
        return view('laporan-pengaduan.showAdmin', compact('laporan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $laporan = LaporanPengaduan::with('boxSampah', 'user')->where('user_id', Auth::id())->find($id);
        $boxSampahs = BoxSampah::all();
        return view('laporan-pengaduan.edit', compact('laporan', 'boxSampahs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'box_sampah_id' => 'required|exists:box_sampahs,id',
            'catatan' => 'required|string',
        ]);

        // Ambil data laporan pengaduan berdasarkan ID dan user yang sedang login
        $laporanPengaduan = LaporanPengaduan::where('user_id', Auth::id())->findOrFail($id);

        // Update data laporan pengaduan
        $laporanPengaduan->update([
            'box_sampah_id' => $request->box_sampah_id,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('laporan-pengaduans.indexNasabah')->with('success', 'Laporan pengaduan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $laporanPengaduan = LaporanPengaduan::findOrFail($id);
            $laporanPengaduan->delete();
        });
        if (Auth::user()->role == 'Admin') {
            return redirect()->route('laporan-pengaduans.index')->with('success', 'Laporan pengaduan berhasil dihapus');
        } else {
            return redirect()->route('laporan-pengaduans.indexNasabah')->with('success', 'Laporan pengaduan berhasil dihapus');
        }
    }
    public function destroyAdmin($id)
    {
        DB::transaction(function () use ($id) {
            $laporanPengaduan = LaporanPengaduan::findOrFail($id);
            $laporanPengaduan->delete();
        });
        return redirect()->route('laporan-pengaduans.index')->with('success', 'Laporan pengaduan berhasil dihapus');
    }
}
