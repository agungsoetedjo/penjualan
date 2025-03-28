<style>
    .jumlah-wrapper {
    height: 30px; /* Kurangi tinggi */
}

.jumlah-wrapper button,
.jumlah-wrapper input {
    height: 28px; /* Sesuaikan dengan wrapper */
    font-size: 0.9rem; /* Kurangi ukuran font */
}
</style>
@foreach($keranjangItems as $index => $item)
    @if ($index > 0)
        <div class="my-3 border-top"></div> <!-- Divider antar produk -->
    @endif
    <div class="d-flex align-items-center">
        <img src="{{ asset($item->produk->gambar) }}" class="img-fluid" style="width: 80px; height: 80px; object-fit: cover;">
        <div class="ms-3 flex-grow-1">
            <h5 class="mb-1" style="font-weight: normal;">{{ $item->produk->nama }}</h5>
        </div>
        <div class="ms-auto text-end" style="font-weight: bold;">
            <p class="mb-0">Rp{{ number_format($item->produk->harga, 0, ',', '.') }}</p>
        </div>
    </div>
    <div class="d-flex justify-content-end align-items-center w-100">
        <div class="d-flex align-items-center">
            <form action="{{ route('keranjang.hapus', $item->id) }}" method="POST" class="me-2">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
            </form>
            <div class="d-flex align-items-center border rounded px-2 py-1 jumlah-wrapper w-100">
                <button type="button" class="btn btn-sm text-danger border-0 kurangi" data-id="{{ $item->produk->id }}" {{ $item->jumlah == 1 ? 'disabled' : '' }}>-</button>
                <input type="text" name="jumlah" class="jumlah-input form-control text-center border-0" 
                value="{{ $item->jumlah }}" readonly style="flex-grow: 1; font-size: 1rem; outline: none; box-shadow: none;">
                <button type="button" class="btn btn-sm text-success border-0 tambah" data-id="{{ $item->produk->id }}">+</button>
            </div>
        </div>
    </div>
@endforeach
