<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ArtikelController extends Controller
{
    public function index(Request $request)
    {
        $artikels = Artikel::latest()->get();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $artikels
            ]);
        }

        $data['page_title'] = 'Artikel Edukasi';
        $data['table_title'] = 'Daftar Artikel';
        $data['artikels'] = $artikels;

        return view('artikels.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Tulis Artikel Baru';
        return view('artikels.create', $data);
    }

    public function store(Request $request)
    {
        $rules = [
            'judul_artikel' => 'required|string|max:255',
            'isi_artikel' => 'required|string',
            'gambar_artikel' => 'nullable',
        ];

        if ($request->hasFile('gambar_artikel')) {
            $rules['gambar_artikel'] = 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048';
        }

        $validated = $request->validate($rules);

        $artikel = new Artikel();
        $artikel->judul_artikel = $validated['judul_artikel'];
        $artikel->isi_artikel = $validated['isi_artikel'];

        if ($request->hasFile('gambar_artikel')) {
            $image = $request->file('gambar_artikel');
            $name = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('ui/images/artikel');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $name);
            $artikel->gambar_artikel = 'ui/images/artikel/' . $name;
        } else {
            $artikel->gambar_artikel = $request->get('gambar_artikel');
        }

        $artikel->save();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Artikel created successfully',
                'data' => $artikel
            ], 201);
        }

        return redirect()->route('artikels.index')->with('success', 'Artikel berhasil dibuat!');
    }

    public function show(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $artikel
            ]);
        }

        $data['page_title'] = $artikel->judul_artikel;
        $data['artikel'] = $artikel;
        return view('artikels.show', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Artikel';
        $data['artikel'] = Artikel::findOrFail($id);
        return view('artikels.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id);

        $rules = [
            'judul_artikel' => 'required|string|max:255',
            'isi_artikel' => 'required|string',
            'gambar_artikel' => 'nullable',
        ];

        if ($request->hasFile('gambar_artikel')) {
            $rules['gambar_artikel'] = 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048';
        }

        $validated = $request->validate($rules);

        $artikel->judul_artikel = $validated['judul_artikel'];
        $artikel->isi_artikel = $validated['isi_artikel'];

        if ($request->hasFile('gambar_artikel')) {
            // Delete old file
            if ($artikel->gambar_artikel) {
                $oldPath = public_path($artikel->gambar_artikel);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $image = $request->file('gambar_artikel');
            $name = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('ui/images/artikel');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $name);
            $artikel->gambar_artikel = 'ui/images/artikel/' . $name;
        } elseif ($request->has('gambar_artikel')) {
            $artikel->gambar_artikel = $request->get('gambar_artikel');
        }

        $artikel->save();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Artikel updated successfully',
                'data' => $artikel
            ]);
        }

        return redirect()->route('artikels.show', $id)->with('success', 'Artikel berhasil diupdate!');
    }

    public function destroy(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id);

        if ($artikel->gambar_artikel) {
            $path = public_path($artikel->gambar_artikel);
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $artikel->delete();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Artikel deleted successfully'
            ]);
        }

        return redirect()->route('artikels.index')->with('success', 'Artikel berhasil dihapus!');
    }
}
