<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
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

        $perPage = $request->get('perPage', 12);
        $search = $request->get('search', '');
        $kategoriId = $request->get('kategori', '');

        $produk = Produk::when($search, function ($query, $search) {
                return $query->where('nama', 'like', "%$search%");
            })
            ->when($kategoriId, function ($query, $kategoriId) {
                return $query->where('kategori_id', $kategoriId);
            })
            ->with(['keranjang' => function ($query) {
                $query->selectRaw('produk_id, SUM(jumlah) as total_dalam_keranjang')->groupBy('produk_id');
            }])
            ->paginate($perPage)
            ->onEachSide(2)
            ->withQueryString();

        $produkNotFound = $produk->isEmpty();
        $kategori = Kategori::all(); // Ambil semua kategori

        if ($request->ajax()) {
            return response()->json([
                'produk' => view('katalog.partial_produk', compact('produk'))->render(),
                'produkNotFound' => $produkNotFound,
                'pagination' => $produk->links('vendor.pagination.bootstrap-5')->render(),
                'produkPagination' => [
                    'from' => $produk->firstItem(),
                    'to' => $produk->lastItem(),
                    'total' => $produk->total(),
                ]
            ]);
        }

        return view('katalog.index', compact('transaksi', 'produk', 'perPage', 'search', 'kategori'));
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
    
        return redirect()->route('katalog.show', $transaksi->id)->with('success', 'Checkout berhasil!');
    }
    

    public function show(Transaksi $transaksi) {
        return view('katalog.show', compact('transaksi'));
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
