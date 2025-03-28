<style>
.jumlah-container {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.jumlah-wrapper {
    display: flex;
    align-items: center;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 5px;
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
            <div class="jumlah-container">
                <div class="d-flex align-items-center border rounded px-2 py-1 jumlah-wrapper w-100">
                    <button type="button" class="btn btn-sm text-danger border-0 kurangi" data-id="{{ $item->produk->id }}" {{ $item->jumlah == 1 ? 'disabled' : '' }}>-</button>
                    <input type="text" name="jumlah" class="jumlah-input form-control text-center border-0 mx-2"
                           value="{{ $item->jumlah }}" data-stok="{{ $item->produk->stok }}"
                           style="width: 50px; font-size: 1rem; outline: none; box-shadow: none;">
                    <button type="button" class="btn btn-sm text-success border-0 tambah" data-id="{{ $item->produk->id }}">+</button>
                </div>
            </div>
        </div>
    </div>
    <div class="stokwarning text-end w-100">
        <span class="text-danger error-stok" style="font-size: 0.8rem; display: none;"></span>
    </div>
@endforeach
