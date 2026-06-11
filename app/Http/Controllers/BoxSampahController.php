<?php

namespace App\Http\Controllers;

use App\Models\BoxSampah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoxSampahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boxSampah = BoxSampah::all();
        return view('box-sampah.index', compact('boxSampah'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('box-sampah.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'id_box' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'description' => 'required',
        ]);

        $boxSampah = BoxSampah::create($request->all());
        return redirect()->route('box-sampahs.index')->with('success', 'Data Box Sampah Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $boxSampah = BoxSampah::find($id);
        return view('box-sampah.show', compact('boxSampah'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $boxSampah = BoxSampah::find($id);
        return view('box-sampah.edit', compact('boxSampah'));
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
            'id_box' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'description' => 'required',
        ]);
        $boxSampah = BoxSampah::find($id);
        $boxSampah->update($request->all());
        return redirect()->route('box-sampahs.index')->with('success', 'Data Box Sampah Berhasil Diubah');
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
            $boxSampah = BoxSampah::findOrFail($id);
            $boxSampah->delete();
        });
        return redirect()->route('box-sampahs.index');
    }
}
