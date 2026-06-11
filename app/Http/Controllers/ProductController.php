<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        return view('data-products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('data-products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'name.required' => 'Nama produk harus diisi.',
            'price.required' => 'Harga produk harus diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'description.required' => 'Deskripsi produk harus diisi.',
            'image.required' => 'Gambar produk harus diisi.',
        ]);

        try {
            $product = new Product();
            $product->name = $validatedData['name'];
            $product->price = $validatedData['price'];
            $product->description = $validatedData['description'];

            // Validasi dan simpan gambar
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $path = $image->storePublicly("images/product", "public");
                $product->image = $path;
            }

            $product->save();

            return redirect()->route('data-products.index')->with('success', 'Produk berhasil disimpan.');
        } catch (\Throwable $th) {
            return redirect()->route('data-products.index')->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, $id)
    {
        $product = Product::findOrFail($id);
        return view('data-products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product, $id)
    {
        $product = Product::findOrFail($id);
        return view('data-products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product, $id)
    {
        // Validasi input dari request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'name.required' => 'Nama produk harus diisi',
            'price.required' => 'Harga produk harus diisi',
            'price.numeric' => 'Harga produk harus berupa angka',
            'description.required' => 'Deskripsi produk harus diisi',
        ]);

        try {
            // Persiapkan data yang akan diupdate
            $data = [
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
                'description' => $validatedData['description'],
            ];

            // Cek apakah ada file gambar yang diupload
            if ($request->hasFile('image')) {
                // Ambil produk yang sesuai dengan ID
                $product = Product::findOrFail($id);

                // Hapus gambar lama jika ada
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }

                // Simpan gambar baru
                $image = $request->file('image');
                $path = $image->storePublicly('images/product', 'public');
                $data['image'] = $path; // Tambahkan path gambar baru ke data
            }

            // Update data produk di database
            Product::where('id', $id)->update($data);

            return redirect()->route('data-products.index')
                ->with('success', 'Data produk berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->route('data-products.index')
                ->with('error', 'Terjadi Kesalahan: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, $id)
    {
        // Hapus file gambar jika ada
        if ($product->image) {
            Storage::delete('public/' . $product->image);
        }

        // Hapus data produk dari database
        Product::where('id', $id)->delete($product);

        // Redirect ke halaman index
        return redirect()->route('data-products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
