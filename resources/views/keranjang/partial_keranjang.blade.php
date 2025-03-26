@foreach($keranjangItems as $item)
    <div class="row align-items-center border-bottom pb-3 mb-3">
        <!-- Gambar Produk -->
        <div class="col-2 col-md-1 text-center">
            <img src="{{ asset('storage/' . $item->produk->gambar) }}" class="img-fluid rounded" style="width: 60px; height: 60px; object-fit: cover;">
        </div>

        <!-- Nama Produk -->
        <div class="col-6 col-md-5">
            <h6 class="mb-1" style="font-weight: normal;">{{ $item->produk->nama }}</h6>
        </div>

        <!-- Harga -->
        <div class="col-4 col-md-2 text-end fw-bold">
            <p class="mb-0">Rp{{ number_format($item->produk->harga, 0, ',', '.') }}</p>
        </div>

        <!-- Tombol Hapus & Jumlah -->
        <div class="col-12 col-md-4 d-flex justify-content-end align-items-center gap-2 mt-2 mt-md-0">
            <form action="{{ route('keranjang.hapus', $item->id) }}" method="POST" class="me-2">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm hapus"><i class="bi bi-trash"></i></button>
            </form>
            
            <div class="d-flex align-items-center">
                <button class="btn btn-light btn-sm kurangi" data-id="{{ $item->produk->id }}" {{ $item->jumlah == 1 ? 'disabled' : '' }}>-</button>
                <input type="text" class="form-control mx-2 text-center" style="width: 50px;" value="{{ $item->jumlah }}" readonly>
                <button class="btn btn-light btn-sm tambah" data-id="{{ $item->produk->id }}">+</button>
            </div>
        </div>
    </div>
@endforeach
