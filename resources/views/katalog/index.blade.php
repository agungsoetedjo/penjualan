@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('error') }}',
        });
    </script>
@endif
@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: '{{ session('success') }}',
        });
    </script>
@endif
<div class="container mt-4">
    <h5>Semua Produk</h5>
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start mb-3">
        <div class="d-flex align-items-center justify-content-center flex-wrap mb-2 mb-md-0">
            <label class="me-2 mb-0">Tampilkan</label>
            <select class="form-select d-inline-block w-auto" id="perPage" style="font-size: 0.8rem;">
                <option value="12" {{ request('perPage') == 12 ? 'selected' : '' }}>12</option>
                <option value="24" {{ request('perPage') == 24 ? 'selected' : '' }}>24</option>
                <option value="48" {{ request('perPage') == 48 ? 'selected' : '' }}>48</option>
            </select>
            <span class="ms-2 mb-0">produk per halaman</span>
        </div>
    
        <div class="w-100 d-flex justify-content-center" style="max-width: 250px;">
            <input style="font-size: 0.8rem;" type="text" id="search" class="form-control text-center text-md-start" placeholder="Cari produk..." value="{{ request('search') }}">
        </div>
        
        <div class="d-flex align-items-center justify-content-center flex-wrap mt-2 mb-md-0">
            <label class="me-2 mb-0">Kategori</label>
            <select class="form-select d-inline-block w-auto" id="filterKategori" style="font-size: 0.8rem;">
                <option value="">*</option>
                @foreach($kategori as $kat)
                    <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                        {{ $kat->nama }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    
    <!-- Pesan Produk Tidak Ditemukan -->
    <div id="produk-not-found" class="alert alert-light text-center" style="display: none; margin-top: 30px;">
    
        <img src="{{ asset('assets/img/4d27af6a.svg') }}" alt="Produk Tidak Ditemukan" class="img-fluid mb-3" style="max-width: 80px;">
        <h4 class="text-muted">Produk tidak ditemukan</h4>
        <p class="text-muted">Coba kata kunci lain atau periksa pengaturan pencarian Anda.</p>
    </div>

    @include('katalog.partial_produk')

    <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-center pt-2 pb-2">
        <div class="cariproduk mb-2 text-center text-md-start">
            @if ($produk->total() > 0) 
            <span style="color: #555;">Menampilkan {{ $produk->firstItem() }} - {{ $produk->lastItem() }} dari {{ $produk->total() }} produk</span>
            @else
                <span style="color: #555;">Tidak ada produk tersedia</span>
            @endif
        </div>
        <div id="pagination" class="mt-2 mt-md-0">
            {{ $produk->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
</div>

<script>
    document.getElementById('perPage').addEventListener('change', function () {
        updateURL();
    });

    document.getElementById('filterKategori').addEventListener('change', function () {
        updateURL();
    });

    let searchTimeout;
    document.getElementById('search').addEventListener('keyup', function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            updateURL();
        }, 1);
    });

    function updateURL(page = 1) {
        let perPage = document.getElementById('perPage').value;
        let kategori = document.getElementById('filterKategori').value;
        let search = document.getElementById('search').value.trim();
        let url = `/katalog?page=${page}&perPage=${perPage}`;

        if (kategori) url += `&kategori=${kategori}`;
        if (search) url += `&search=${encodeURIComponent(search)}`;

        fetch(url, { headers: { "X-Requested-With": "XMLHttpRequest" } })
            .then(response => response.json())
            .then(data => {
                document.getElementById('produk-list').innerHTML = data.produk;
                document.querySelector('.cariproduk').innerHTML = data.produkPagination.total > 0 
                    ? `Menampilkan ${data.produkPagination.from} - ${data.produkPagination.to} dari ${data.produkPagination.total} produk`
                    : `Tidak ada produk tersedia`;
                
                document.getElementById('pagination').innerHTML = data.pagination;
                document.getElementById('produk-not-found').style.display = data.produkNotFound ? 'block' : 'none';
                
                history.replaceState(null, "", url);
            })
            .catch(error => console.error('Error:', error));
    }
</script>

@endsection
