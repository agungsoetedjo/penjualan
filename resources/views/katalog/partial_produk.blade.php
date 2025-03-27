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
<div class="container mt-3">
    <div class="row justify-content-start g-3" id="produk-list">
        @foreach($produk as $p)
        @php
        $jumlahDiKeranjang = $p->keranjang->sum('total_dalam_keranjang') ?? 0;
        $stokTersisa = max(0, $p->stok - $jumlahDiKeranjang);
        @endphp
        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
            <div class="card shadow-sm border-0 rounded-2 m-0">
                <div class="img-container position-relative" style="width: 100%; height: 150px; overflow: hidden; background: #f8f8f8;">
                    <img src="{{ asset($p->gambar) }}" alt="{{ $p->nama }}" 
                        style="width: 100%; height: 100%; object-fit: contain; background-color: #f8f9fa;">
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
                            @if ($stokTersisa == 0)
                            <span style="font-size: 0.7rem;" class="btn btn-danger btn-sm w-100">
                                Stok Habis
                            </span>
                            @else
                            <div class="d-flex flex-column">
                                <!-- Wrapper untuk Input Jumlah (Selebar Card) -->
                                <div class="d-flex align-items-center border rounded px-2 py-1 jumlah-wrapper w-100">
                                    <button type="button" class="btn btn-sm border-0 minus-btn">-</button>
                                    <input type="text" name="jumlah" class="jumlah-input form-control text-center border-0"
                                        value="1" min="1" max="{{ $stokTersisa }}" readonly
                                        data-stok="{{ $stokTersisa }}" 
                                        style="flex-grow: 1; font-size: 1rem; outline: none; box-shadow: none;">
                                    <button type="button" class="btn btn-sm text-success border-0 plus-btn">+</button>
                                </div>
                            
                                <!-- Wrapper untuk Tombol Beli (Selebar Card) -->
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-success btn-sm w-100"
                                        style="font-size: 0.8rem; white-space: nowrap;">
                                        <i class="bi bi-cart-plus"></i> Beli
                                    </button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </form>
                    @else
                    <span style="font-size: 0.7rem;" class="btn btn-danger btn-sm w-100">
                        Stok Habis
                    </span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".jumlah-wrapper").forEach(wrapper => {
            let minusBtn = wrapper.querySelector(".minus-btn");
            let plusBtn = wrapper.querySelector(".plus-btn");
            let inputJumlah = wrapper.querySelector(".jumlah-input");
            let maxStok = parseInt(inputJumlah.getAttribute("max")) || 1;
    
            minusBtn.addEventListener("click", function () {
                let value = parseInt(inputJumlah.value) || 1;
                if (value > 1) {
                    inputJumlah.value = value - 1;
                }
            });
    
            plusBtn.addEventListener("click", function () {
                let value = parseInt(inputJumlah.value) || 1;
                if (value < maxStok) {
                    inputJumlah.value = value + 1;
                } else {
                    Swal.fire({
                        icon: "warning",
                        title: "Stok Maksimal!",
                        text: "Jumlah produk sudah mencapai stok maksimal.",
                        confirmButtonColor: "#d33",
                        confirmButtonText: "OK"
                    });
                }
            });
        });
    });
    </script>
    