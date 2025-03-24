<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        return view('kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:kategori,nama',
        ]);
    
        Kategori::create(['nama' => $request->nama]);
    
        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        Kategori::destroy($id);
        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:kategori,nama,' . $id,
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update(['nama' => $request->nama]);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui!');
    }
}
