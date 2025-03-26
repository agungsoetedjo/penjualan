@foreach($keranjangItems as $item)
    <div class="d-flex align-items-center border-bottom pb-3 mb-3">
        <!-- Gambar Produk -->
        <img src="{{ asset('storage/' . $item->produk->gambar) }}" class="img-fluid" style="width: 80px; height: 80px; object-fit: cover;">
        
        <!-- Nama Produk -->
        <div class="ms-3 flex-grow-1">
            <h5 class="mb-1" style="font-weight: normal;">{{ $item->produk->nama }}</h5>
        </div>

        <!-- Harga -->
        <div class="ms-auto text-end" style="font-weight: bold;">
            <p class="mb-0">Rp{{ number_format($item->produk->harga, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Tombol Hapus & Jumlah -->
    <div class="d-flex justify-content-end align-items-center mt-2 w-100">
        <div class="d-flex align-items-center">
            <form action="{{ route('keranjang.hapus', $item->id) }}" method="POST" class="me-2">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
            </form>
            <button class="btn btn-light btn-sm kurangi" data-id="{{ $item->produk->id }}" {{ $item->jumlah == 1 ? 'disabled' : '' }}>-</button>
            <input type="text" class="form-control mx-2 text-center" style="width: 50px;" value="{{ $item->jumlah }}" readonly>
            <button class="btn btn-light btn-sm tambah" data-id="{{ $item->produk->id }}">+</button>
        </div>
    </div>
@endforeach
