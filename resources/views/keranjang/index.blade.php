@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<style>
button.btn-sm {
    min-width: 30px;
    padding: 0.2rem 0.5rem;
}

input.form-control {
    width: 50px;
    height: 30px;
}
</style>
<div class="container mt-4">
    <h3 class="mb-4">Keranjang</h3>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
        });
    </script>
    @endif

    @if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('error') }}',
        });
    </script>
    @endif

    @if($keranjang->isEmpty())
        <div class="row">
            <div class="col-md-8">
                <div class="card p-3 shadow mb-3" style="border-radius: 8px;">
                    <div class="text-center">
                        <img src="{{ asset('assets/img/4d27af6a.svg') }}" alt="Keranjang Kosong" class="mb-3" style="max-width: 100px; height: auto;">
                        <h5 style="font-size: 1.2rem;">Keranjang Anda kosong</h5>
                        <p class="text-muted" style="font-size: 1rem;">Segera tambahkan produk ke keranjang Anda.</p>
                        <a href="/transaksi" class="btn btn-success" style="font-size: 1rem; padding: 8px 16px;">Mulai Belanja</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3 mb-3 shadow" style="border-radius: 8px;">
                    <h5>Ringkasan belanja</h5>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Total</span>
                        <h5 class="fw-bold mb-0 text-end">-</h5>
                    </div>
                    <form action="{{ route('transaksi.checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100 mt-3" disabled>Checkout</button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-8">
                <div class="card p-3 mb-3">
                    @foreach($keranjang as $item)
                    <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                        <!-- Gambar Produk -->
                        <img src="{{ asset('storage/' . $item->produk->gambar) }}" class="img-fluid" style="width: 80px; height: 80px; object-fit: cover;">
                    
                        <!-- Div untuk Judul Produk -->
                        <div class="ms-3 flex-grow-1">
                            <!-- Judul Produk -->
                            <h5 class="mb-1" style="font-weight: normal;">{{ $item->produk->nama }}</h5>
                        </div>
                    
                        <!-- Div untuk Harga Produk, diposisikan ke kanan -->
                        <div class="ms-auto text-end" style="font-weight: bold;">
                            <p class="mb-0">Rp{{ number_format($item->produk->harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    
                    <!-- Tombol Hapus, Kurangi, dan Tambah, diposisikan ke kanan tengah -->
                    <div class="d-flex justify-content-end align-items-center mt-2 w-100">
                        <div class="d-flex align-items-center">
                            <!-- Tombol Hapus -->
                            <form action="{{ route('keranjang.hapus', $item->id) }}" method="POST" class="me-2">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </form>
                    
                            <!-- Tombol Kurangi Jumlah -->
                            <form action="{{ route('keranjang.kurangi', $item->produk->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-light btn-sm">-</button>
                            </form>
                    
                            <!-- Input Jumlah Produk -->
                            <input type="text" class="form-control mx-2 text-center" style="width: 50px;" value="{{ $item->jumlah }}" readonly>
                    
                            <!-- Tombol Tambah Jumlah -->
                            <form action="{{ route('keranjang.tambah', $item->produk->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-light btn-sm">+</button>
                            </form>
                        </div>
                    </div>
                    
                    @endforeach
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3 mb-3 shadow" style="border-radius: 8px;">
                    <h5>Ringkasan belanja</h5>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Total</span>
                        <h5 class="fw-bold mb-0 text-end">Rp{{ number_format($totalHarga, 0, ',', '.') }}</h5>
                    </div>
                    <form action="{{ route('transaksi.checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100 mt-3" 
                            @if($keranjang->isEmpty()) disabled @endif>Checkout</button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
