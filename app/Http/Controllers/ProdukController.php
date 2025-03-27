<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::with('kategori')->get();
        $kategori = Kategori::all();
        return view('produk.index', compact('produk', 'kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:produk,nama',
            'harga' => 'required|numeric|min:1',
            'stok' => 'required|integer|min:0',
            'kategori_id' => 'required|exists:kategori,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:8192'
        ]);

        $gambarPath = null; // Default null jika tidak ada gambar

        // **Upload gambar ke public/produk_img/**
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('produk_img'), $filename);
            $gambarPath = 'produk_img/' . $filename; // Simpan path di database
        }

        Produk::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'kategori_id' => $request->kategori_id,
            'gambar' => $gambarPath,
        ]);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
    }

    public function destroy(Produk $produk)
    {
        Storage::delete('public/' . $produk->gambar);
        $produk->delete();
        return redirect()->back()->with('success', 'Produk berhasil dihapus');
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'kategori_id' => 'required|exists:kategori,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:8192'
        ]);

        // **Hapus gambar lama jika ada & user upload gambar baru**
        if ($request->hasFile('gambar')) {
            if ($produk->gambar && File::exists(public_path($produk->gambar))) {
                File::delete(public_path($produk->gambar)); // Hapus gambar lama
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('produk_img'), $filename);
            $produk->gambar = 'produk_img/' . $filename; // Simpan path baru
        }

        // **Update data produk**
        $produk->update([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'kategori_id' => $request->kategori_id,
            'gambar' => $produk->gambar, // Update gambar jika ada
        ]);

        return redirect()->back()->with('success', 'Produk berhasil diperbarui');
    }
}
