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
        $keranjang = Keranjang::with('produk')->get();
        // Hitung total belanja langsung dari produk
        $totalHarga = $keranjang->sum(fn($item) => $item->jumlah * $item->produk->harga);
    
        return view('keranjang.index', compact('keranjang', 'totalHarga'));
    }

    public function checkout()
    {
        $keranjang = Keranjang::with('produk')->get();

        if ($keranjang->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang masih kosong!');
        }

        try {
            // 1. Buat transaksi baru
            $totalHarga = $keranjang->sum(fn($item) => $item->produk->harga * $item->jumlah);
            $transaksi = Transaksi::create([
                'kode_transaksi' => 'TRX-' . Str::upper(Str::random(8)),
                'total_harga' => $totalHarga,
                'status' => 'pending'
            ]);

            // 2. Simpan detail transaksi dan kurangi stok produk
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

            // 3. Kosongkan keranjang
            Keranjang::truncate();

            return redirect()->route('keranjang.index')->with('success', 'Checkout berhasil!');
        } catch (\Exception $e) {
            return redirect()->route('keranjang.index')->with('error', 'Terjadi kesalahan saat checkout.');
        }
    }

    public function tambah(Request $request, $id)
    {
        $jumlah = $request->input('jumlah', 1); // Ambil jumlah dari input, default 1
        $produk = Produk::findOrFail($id);

        if ($produk->stok < $jumlah) {
            return redirect()->route('keranjang.index')->with('error', 'Stok produk tidak mencukupi.');
        }
        // Cek apakah produk sudah ada di keranjang
        $keranjang = Keranjang::where('produk_id', $id)->first();

        if ($keranjang) {
            // Jika sudah ada, tambah jumlah
            $keranjang->increment('jumlah', $jumlah);
        } else {
            // Jika belum ada, tambahkan item baru
            Keranjang::create([
                'produk_id' => $id,
                'jumlah' => $jumlah,
            ]);
        }
        $source = $request->input('source', '');  // Defaultnya kosong jika tidak ada 'source'

        // Jika datang dari halaman transaksi
        if ($source == 'transaksi') {
            return redirect()->route('keranjang.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
        }

        // Jika datang dari halaman keranjang
        return redirect()->route('keranjang.index');
    }

    public function kurangi($id)
    {
        // Ambil data keranjang berdasarkan produk_id
        $keranjang = Keranjang::where('produk_id', $id)->first();

        if ($keranjang) {
            if ($keranjang->jumlah > 1) {
                // Kurangi jumlah produk
                $keranjang->decrement('jumlah');
            } else {
                // Jika jumlah produk sudah 1, hapus produk dari keranjang
                $keranjang->delete();
                return redirect()->route('keranjang.index');
            }
        }

        // Ambil ulang semua item di keranjang
        $keranjang = Keranjang::with('produk')->get();

        // Hitung total harga setelah perubahan
        $totalHarga = $keranjang->sum(function ($item) {
            return $item->jumlah * $item->produk->harga;
        });

        // Kembalikan total harga dan data keranjang ke view
        return redirect()->route('keranjang.index')->with(['keranjang' => $keranjang, 'totalHarga' => $totalHarga]);
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
}
