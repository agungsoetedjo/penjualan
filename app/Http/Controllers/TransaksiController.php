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

    public function riwayatTransaksi(Request $request)
    {
        $status = $request->query('status');
        $query = Transaksi::with('details.produk')->orderBy('created_at', 'desc');

        if ($status) {
            $query->where('status', $status);
        }

        $transaksi = $query->get();

        return view('transaksi.riwayat', compact('transaksi', 'status'));
    }

    public function updateStatus(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update(['status' => $request->status]);

        return back()->with('success', 'Status transaksi berhasil diperbarui.');
    }

}
