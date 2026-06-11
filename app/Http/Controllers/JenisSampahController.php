<?php

namespace App\Http\Controllers;

use App\Models\JenisSampah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class JenisSampahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['jenis_sampahs'] = JenisSampah::orderBy('nama', 'asc')->get();
        return view('jenis-sampah.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jenis-sampah.create');
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
            $jenis_sampah = new JenisSampah();
            $jenis_sampah->nama = $request->nama;
            $jenis_sampah->harga = $request->harga;
            $jenis_sampah->gramasi = $request->gramasi;
            $jenis_sampah->catatan = $request->catatan;
            $jenis_sampah->save();
            return redirect()->route('jenis_sampahs.index');

        } catch (\Throwable $th) {
            return redirect()->route('jenis_sampahs.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JenisSampah  $jenisSampah
     * @return \Illuminate\Http\Response
     */
    public function show(JenisSampah $jenisSampah)
    {
        $data['jenis_sampah'] = $jenisSampah;
        return view('jenis-sampah.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JenisSampah  $jenisSampah
     * @return \Illuminate\Http\Response
     */
    public function edit(JenisSampah $jenisSampah)
    {
        $data['jenis_sampah'] = $jenisSampah;
        return view('jenis-sampah.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JenisSampah  $jenisSampah
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $jenis_sampah = JenisSampah::findOrFail($id);
            $jenis_sampah->nama = $request->nama;
            $jenis_sampah->harga = $request->harga;
            $jenis_sampah->gramasi = $request->gramasi;
            $jenis_sampah->catatan = $request->catatan;
            $jenis_sampah->save();

            return redirect()->route('jenis_sampahs.index');

        } catch (\Throwable $th) {
            return redirect()->route('jenis_sampahs.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JenisSampah  $jenisSampah
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $jenis_sampah = JenisSampah::findOrFail($id);
            $jenis_sampah->delete();
        });
        return redirect()->route('jenis_sampahs.index');

    }
}
