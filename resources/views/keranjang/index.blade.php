@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
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

    @if($keranjang->isEmpty())
        <div class="row"> <!-- Tambahkan mb-4 untuk memberi jarak lebih -->
            <!-- Panel Keranjang Kosong -->
            <div class="col-md-8">
                <div class="card p-3 shadow mb-3" style="border-radius: 8px;">
                    <div class="text-center">
                        <!-- Gambar Keranjang Kosong -->
                        <img src="{{ asset('assets/img/4d27af6a.svg') }}" alt="Keranjang Kosong" class="mb-3" style="max-width: 100px; height: auto;">
                        
                        <!-- Pesan Keranjang Kosong -->
                        <h5 style="font-size: 1.2rem;">Keranjang Anda kosong</h5>
                        <p class="text-muted" style="font-size: 1rem;">Segera tambahkan produk ke keranjang Anda.</p>
                        <a href="/transaksi" class="btn btn-success" style="font-size: 1rem; padding: 8px 16px;">Mulai Belanja</a>
                    </div>
                </div>
            </div>

            <!-- Panel Total Belanja -->
            <div class="col-md-4">
                <div class="card p-3 mb-3 shadow" style="border-radius: 8px;">
                    <h5>Ringkasan Belanja</h5>
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
                        <img src="{{ asset('storage/' . $item->produk->gambar) }}" class="img-fluid" style="width: 80px; height: 80px; object-fit: cover;">
                        
                        <div class="ms-3 flex-grow-1">
                            <!-- Judul Produk -->
                            <h5 class="mb-1" style="font-weight: normal;">{{ $item->produk->nama }}</h5>
                        </div>
                    
                        <div class="ms-3 flex-grow-1">
                            <!-- Harga Produk di sebelah kanan -->
                            <p class="text-muted mb-0 text-end">Rp{{ number_format($item->produk->harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    
                    <div class="d-flex flex-column mt-2">
                        <div class="d-flex justify-content-end align-items-center w-100">
                            <form action="{{ route('keranjang.hapus', $item->id) }}" method="POST" class="me-2">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                            <form action="{{ route('keranjang.kurangi', $item->produk->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-light btn-sm">-</button>
                            </form>
                            <input type="text" class="form-control mx-2 text-center" style="width: 50px;" value="{{ $item->jumlah }}" readonly>
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
                    <h5>Ringkasan Belanja</h5>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Total Belanja</span>
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
