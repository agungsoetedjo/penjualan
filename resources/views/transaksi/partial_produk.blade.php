<div class="row row-cols-auto g-3">
    @foreach($produk as $p)
    <div class="col">
        <div class="card shadow-sm border-0 rounded-2 m-0" style="width: 200px;">
            <div class="img-container position-relative" style="width: 100%; height: 150px; overflow: hidden; background: #f8f8f8;">
                <img src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->nama }}"
                    style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div class="card-body px-2 py-2">
                <span class="d-block text-truncate" style="font-size: 0.8rem; font-weight: 500;">
                    {{ $p->nama }}
                </span>
                <h6 class="text-success font-weight-bold mb-0">Rp{{ number_format($p->harga, 0, ',', '.') }}</h6>
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
<div class="d-flex flex-column flex-md-row justify-content-md-between align-items-center pb-2">
    <div class="mb-2 text-center text-md-start">
        @if ($produk->total() > $produk->count()) 
            <span style="color: #555;">Menampilkan {{ $produk->firstItem() }} - {{ $produk->lastItem() }} dari {{ $produk->total() }} produk</span>
        @endif
    </div>
    <div class="mt-2 mt-md-0">
        {{ $produk->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>
