@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
<div class="container mt-4">
    <h5>Semua Produk</h5>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <label class="me-2">Tampilkan</label>
            <select class="form-select d-inline-block w-auto" id="perPage">
                <option value="12" {{ request('perPage') == 12 ? 'selected' : '' }}>12</option>
                <option value="24" {{ request('perPage') == 24 ? 'selected' : '' }}>24</option>
                <option value="48" {{ request('perPage') == 48 ? 'selected' : '' }}>48</option>
            </select>
            <span class="ms-1">produk per halaman</span>
        </div>
    
        <div>
            <input type="text" id="search" class="form-control d-inline-block w-auto" placeholder="Cari produk..." value="{{ request('search') }}">
        </div>
    </div>

    <div class="container mt-3">
        <div class="row justify-content-start g-3" id="produk-list">
            @foreach($produk as $p)
            <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                <div class="card shadow-sm border-0 rounded-2 m-0">
                    <div class="img-container position-relative" style="width: 100%; height: 150px; overflow: hidden; background: #f8f8f8;">
                        <img src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->nama }}" 
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
</div>

<script>
    document.getElementById('perPage').addEventListener('change', function () {
        let search = document.getElementById('search').value.trim(); // Hilangkan spasi kosong
        let url = "/katalog?perPage=" + this.value;
        if (search) {
            url += "&search=" + encodeURIComponent(search);
        }
        window.location.href = url;
    });

    let searchTimeout;
    document.getElementById('search').addEventListener('keyup', function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            fetchProduk();
        }, 500); // 500ms delay agar tidak langsung request saat user mengetik
    });

    function fetchProduk() {
        let perPage = document.getElementById('perPage').value;
        let search = document.getElementById('search').value.trim(); // Hilangkan spasi kosong
        let url = `/katalog?perPage=${perPage}`;

        if (search) {
            url += `&search=${encodeURIComponent(search)}`; // Menambahkan parameter search jika ada
        }

        fetch(url, {
            headers: { "X-Requested-With": "XMLHttpRequest" } // Deteksi request AJAX
        })
        .then(response => response.json())  // Mengubah response menjadi JSON
        .then(data => {
            // Update produk dan pagination
            document.getElementById('produk-list').innerHTML = data.produk; // Mengganti isi produk
            // Update URL tanpa &search= jika input kosong
            history.replaceState(null, "", url);
        })
        .catch(error => {
            console.error('Error:', error); // Log error jika ada
        });
    }
</script>
@endsection
