<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Support\Str;

class KeranjangController extends Controller
{

    public function index() {
        $keranjangItems = Keranjang::with('produk')->get();
        $totalHarga = $keranjangItems->sum(fn($item) => $item->jumlah * $item->produk->harga);
    
        return view('keranjang.index', compact('keranjangItems', 'totalHarga'));
    }

    public function checkout()
    {
        $keranjang = Keranjang::with('produk')->get();

        if ($keranjang->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang masih kosong!');
        }

        try {
            $totalHarga = $keranjang->sum(fn($item) => $item->produk->harga * $item->jumlah);
            $transaksi = Transaksi::create([
                'kode_transaksi' => 'TRX-' . Str::upper(Str::random(8)),
                'total_harga' => $totalHarga,
                'status' => 'pending'
            ]);
            foreach ($keranjang as $item) {
                $produk = $item->produk;
                if ($produk->stok < $item->jumlah) {
                    return redirect()->route('keranjang.index')->with('error', 'Stok tidak mencukupi.');
                }
                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $produk->id,
                    'jumlah' => $item->jumlah,
                    'subtotal' => $item->jumlah * $produk->harga
                ]);
                $produk->stok -= $item->jumlah;
                $produk->save();
            }
            Keranjang::truncate();
            return redirect()->route('keranjang.index')->with('success', 'Checkout berhasil!');
        } catch (\Exception $e) {
            return redirect()->route('keranjang.index')->with('error', 'Terjadi kesalahan saat checkout.');
        }
    }

    // public function kurangi($id)
    // {
    //     $keranjang = Keranjang::where('produk_id', $id)->first();

    //     if ($keranjang && $keranjang->jumlah > 1) {
    //         $keranjang->decrement('jumlah');
    //     }
    //     $keranjangItems = Keranjang::with('produk')->get();
    //     $totalHarga = $keranjangItems->sum(function ($item) {
    //         return $item->jumlah * $item->produk->harga;
    //     });
    //     return response()->json([
    //         'keranjang' => view('keranjang.partial_keranjang', compact('keranjangItems'))->render(),
    //         'totalHarga' => number_format($totalHarga, 0, ',', '.'),
    //     ]);
    // }

    // public function tambah(Request $request, $id)
    // {
    //     $jumlah = $request->input('jumlah', 1);
    //     $produk = Produk::findOrFail($id);
    //     $keranjang = Keranjang::where('produk_id', $id)->first();

    //     if ($keranjang) {
    //         $keranjang->increment('jumlah',$jumlah);
    //     } else {
    //         Keranjang::create([
    //             'produk_id' => $id,
    //             'jumlah' => $jumlah,
    //         ]);
    //     }
    //     $keranjangItems = Keranjang::with('produk')->get();
    //     $totalHarga = $keranjangItems->sum(function ($item) {
    //         return $item->jumlah * $item->produk->harga;
    //     });
    //     return response()->json([
    //         'keranjang' => view('keranjang.partial_keranjang', compact('keranjangItems'))->render(),
    //         'totalHarga' => number_format($totalHarga, 0, ',', '.'),
    //     ]);
    // }

    public function updateKeranjang(Request $request)
    {
        $keranjang = Keranjang::where('produk_id', $request->produk_id)->first();

        if (!$keranjang) {
            return response()->json(['status' => 'error', 'message' => 'Produk tidak ditemukan di keranjang'], 404);
        }

        $produk = Produk::find($request->produk_id);
        if (!$produk) {
            return response()->json(['status' => 'error', 'message' => 'Produk tidak ditemukan'], 404);
        }

        // Cek stok sebelum update
        if ($request->jumlah > $produk->stok) {
            return response()->json([
                'status' => 'error',
                'message' => 'Stok tidak mencukupi!'
            ]);
        }

        // Update jumlah di keranjang
        $keranjang->update(['jumlah' => $request->jumlah]);

        // Hitung subtotal untuk item ini
        $subtotal = $keranjang->jumlah * $produk->harga;

        // Hitung total belanja
        $total = Keranjang::with('produk')->get()->sum(function ($item) {
            return $item->jumlah * $item->produk->harga;
        });

        return response()->json([
            'status' => 'success',
            'jumlah' => $keranjang->jumlah,
            'subtotal' => number_format($subtotal, 0, ',', '.'),
            'total' => number_format($total, 0, ',', '.')
        ]);
    }

    public function tambahKeKeranjang(Request $request, $id)
    {
        $jumlah = $request->input('jumlah', 1);
        $keranjang = Keranjang::where('produk_id', $id)->first();

        if ($keranjang) {
            $keranjang->increment('jumlah', $jumlah);
        } else {
            Keranjang::create([
                'produk_id' => $id,
                'jumlah' => $jumlah,
            ]);
        }

        return redirect()->route('keranjang.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }


    public function hapus($id)
    {
        $item = Keranjang::find($id);

        if (!$item) {
            return redirect()->route('keranjang.index')->with('error', 'Item tidak ditemukan!');
        }
        $item->delete();
        return redirect()->route('keranjang.index')->with('success', 'Item berhasil dihapus dari keranjang!');
    }

    public function kurangiAjax($id)
    {
        $keranjang = Keranjang::where('produk_id', $id)->first();
        if ($keranjang && $keranjang->jumlah > 1) {
            $keranjang->decrement('jumlah');
        }
        $keranjangItems = Keranjang::with('produk')->get();
        $totalHarga = $keranjangItems->sum(function ($item) {
            return $item->jumlah * $item->produk->harga;
        });
        return response()->json([
            'keranjang' => view('keranjang.partial_keranjang', compact('keranjangItems'))->render(),
            'totalHarga' => $totalHarga
        ]);
    }

    public function tambahAjax($id)
    {
        $keranjang = Keranjang::where('produk_id', $id)->first();

        if ($keranjang) {
            $keranjang->increment('jumlah');
        }
        $keranjangItems = Keranjang::with('produk')->get();
        $totalHarga = $keranjangItems->sum(function ($item) {
            return $item->jumlah * $item->produk->harga;
        });
        return response()->json([
            'keranjang' => view('keranjang.partial_keranjang', compact('keranjangItems'))->render(),
            'totalHarga' => $totalHarga
        ]);
    }
}
