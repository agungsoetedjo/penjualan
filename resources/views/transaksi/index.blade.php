@extends('layouts.app')

@section('title', 'Transaksi & Produk')

@section('content')
<div class="container mt-4">
    <h3>Riwayat Transaksi</h3>

    @if($transaksi->isEmpty())
        <div class="alert alert-warning">Belum ada transaksi.</div>
    @else
        <div class="row">
            @foreach ($produk as $p)
            <div class="card" style="width: 18rem;">
                <img src="{{ asset('storage/' . $p->gambar) }}" class="card-img-top" alt="{{ $p->nama }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $p->nama }}</h5>
                    <p class="card-text">Rp{{ number_format($p->harga, 0, ',', '.') }}</p>
                    <form action="{{ route('keranjang.tambah', ['id' => $p->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    @endif

    <hr>

    <h5>Produk yang Tersedia</h5>
    <div class="row">
        @foreach($produk as $p)
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm" style="border: 1px solid #f0f0f0; border-radius: 8px; overflow: hidden;">
                <div class="img-container" style="width: 100%; height: 200px; overflow: hidden;">
                    <img src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->nama }}" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <div class="card-body p-3">
                    <span class="card-title" style="font-size: 1rem; font-weight: normal; display: block; margin-bottom: 5px;">{{ $p->nama }}</span>
                    <h6 class="card-text text-success font-weight-bold" style="margin-bottom: 15px;">Rp{{ number_format($p->harga, 0, ',', '.') }}</h6>
                    <form action="{{ route('keranjang.tambah', ['id' => $p->id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="source" value="transaksi"> <!-- Menambahkan source transaksi -->
                        <input type="hidden" name="produk_id" value="{{ $p->id }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <input type="number" name="jumlah" class="form-control form-control-sm" value="1" min="1" max="{{ $p->stok }}" required style="width: 60px;">
                            <button type="submit" class="btn btn-success btn-sm" title="Tambah ke Keranjang"><i class="bi bi-cart"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        @endforeach
    </div>
</div>

@endsection
