<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransaksiController extends Controller {

    public function index(Request $request)
    {
        $transaksi = Transaksi::with('items.produk')->latest()->get();

        $perPage = $request->get('perPage', 12); // Default 6 produk per halaman
        $search = $request->get('search', ''); // Set default kosong agar tidak null

        $produk = Produk::when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%$search%");
        })->paginate($perPage)->onEachSide(2)->withQueryString();

        if ($request->ajax()) {
            return view('transaksi.partial_produk', compact('produk'))->render();
        }
        
        return view('transaksi.katalog_produk', compact('transaksi', 'produk', 'perPage', 'search'));
    }



    public function checkout() {
        $keranjang = Keranjang::with('produk')->get(); // Ambil semua data keranjang
    
        if ($keranjang->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kosong.');
        }
    
        // Hitung total belanja
        $total = $keranjang->sum(fn($item) => $item->jumlah * $item->produk->harga);
    
        // Simpan transaksi
        $transaksi = Transaksi::create([
            'kode_transaksi' => 'TRX-' . strtoupper(Str::random(10)),
            'total_harga' => $total,
            'status' => 'pending'
        ]);
    
        // Simpan detail transaksi
        foreach ($keranjang as $item) {
            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'produk_id' => $item->produk_id,
                'jumlah' => $item->jumlah,
                'subtotal' => $item->jumlah * $item->produk->harga
            ]);
        }
    
        Keranjang::truncate();
    
        return redirect()->route('transaksi.show', $transaksi->id)->with('success', 'Checkout berhasil!');
    }
    

    public function show(Transaksi $transaksi) {
        return view('transaksi.show', compact('transaksi'));
    }

    public function prosesCheckout()
    {
        $keranjang = Keranjang::with('produk')->get();

        if ($keranjang->isEmpty()) {
            return redirect('/keranjang')->with('error', 'Keranjang kosong!');
        }

        $total_harga = $keranjang->sum(fn($item) => $item->produk->harga * $item->jumlah);

        $transaksi = Transaksi::create(['total_harga' => $total_harga]);

        foreach ($keranjang as $item) {
            Transaksi::create([
                'transaksi_id' => $transaksi->id,
                'produk_id' => $item->produk_id,
                'jumlah' => $item->jumlah,
                'subtotal' => $item->produk->harga * $item->jumlah,
            ]);
        }

        Keranjang::truncate();

        return redirect('/')->with('success', 'Transaksi berhasil!');
    }

}
