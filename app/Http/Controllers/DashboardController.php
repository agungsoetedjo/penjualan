<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduk = Produk::count();
        $totalKategori = Kategori::count();

        $kategoriProduk = Kategori::leftJoin('produk', 'kategori.id', '=', 'produk.kategori_id')
            ->selectRaw('kategori.nama, COUNT(produk.id) as total_produk')
            ->groupBy('kategori.nama')
            ->get();

        // Pastikan data tidak kosong
        if ($kategoriProduk->isEmpty()) {
            $kategoriLabels = [];
            $kategoriCounts = [];
        } else {
            $kategoriLabels = $kategoriProduk->pluck('nama')->toArray();
            $kategoriCounts = $kategoriProduk->pluck('total_produk')->toArray();
        }

        return view('dashboard.index', compact('totalProduk', 'totalKategori', 'kategoriLabels', 'kategoriCounts'));
    }

}
