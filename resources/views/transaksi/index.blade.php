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
    <h5>Semua Produk</h5>
    <div class="row row-cols-auto g-3"> <!-- g-0 agar tidak ada gap antar col -->
        @foreach($produk as $p)
        <div class="col">
            <div class="card shadow-sm border-0 rounded-2 m-0" style="width: 200px;"> <!-- m-0 agar tidak ada margin -->
                <!-- Gambar Produk -->
                <div class="img-container position-relative" style="width: 100%; height: 150px; overflow: hidden; background: #f8f8f8;">
                    <img src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->nama }}"
                        style="width: 100%; height: 100%; object-fit: cover;">
                </div>

                <!-- Konten Produk -->
                <div class="card-body px-2 py-2"> <!-- px-1 supaya tidak ada spasi berlebih -->
                    <span class="d-block text-truncate" style="font-size: 0.8rem; font-weight: 500;">
                        {{ $p->nama }}
                    </span>
                    <h6 class="text-success font-weight-bold mb-0">Rp{{ number_format($p->harga, 0, ',', '.') }}</h6>

                    <!-- Rating dan Terjual -->
                    <div class="d-flex align-items-center" style="font-size: 0.7rem; color: #666;">
                        <i class="bi bi-star-fill text-warning me-1"></i> 4.8 | 26 terjual
                    </div>

                    @if ($p->stok > 0)
                    <form action="{{ route('keranjang.tambahKeKeranjang', ['id' => $p->id]) }}" method="POST">
                        @csrf
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <input type="number" name="jumlah" class="form-control form-control-sm text-center"
                                value="1" min="1" max="{{ $p->stok }}" required
                                style="width: 50px; font-size: 0.7rem;">
                            <button type="submit" class="btn btn-success btn-sm px-2"
                                style="font-size: 0.7rem;">
                                <i class="bi bi-cart-plus"></i> Beli
                            </button>
                        </div>
                    </form>
                    @else
                    <button class="btn btn-danger btn-sm w-100 mt-1" disabled>
                        Stok Habis
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('error') }}',
        });
    </script>
@endif
@endsection
