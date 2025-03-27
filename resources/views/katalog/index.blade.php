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
    <!-- Pesan Produk Tidak Ditemukan -->
    <div id="produk-not-found" class="alert alert-light text-center" style="display: none; margin-top: 30px;">
    
        <img src="{{ asset('assets/img/4d27af6a.svg') }}" alt="Produk Tidak Ditemukan" class="img-fluid mb-3" style="max-width: 80px;">
        <h4 class="text-muted">Produk tidak ditemukan</h4>
        <p class="text-muted">Coba kata kunci lain atau periksa pengaturan pencarian Anda.</p>
    </div>

    @include('katalog.partial_produk')

    <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-center pt-2 pb-2">
        <div class="mb-2 text-center text-md-start">
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
        }, 1); // 500ms delay agar tidak langsung request saat user mengetik
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
            
            // Menampilkan pesan jika produk tidak ditemukan
            if (data.produkNotFound) {
                document.getElementById('produk-not-found').style.display = 'block';
            } else {
                document.getElementById('produk-not-found').style.display = 'none';
            }

            // Update keterangan produk yang ditampilkan
            if (data.produkPagination.total > 0) {
                document.querySelector('.text-center.text-md-start').innerHTML = 
                    `Menampilkan ${data.produkPagination.from} - ${data.produkPagination.to} dari ${data.produkPagination.total} produk`;
                    document.getElementById('pagination').innerHTML = data.pagination;
                    document.getElementById('pagination').style.display = 'block';
            } else {
                document.querySelector('.text-center.text-md-start').innerHTML = `Tidak ada produk tersedia`;
                document.getElementById('pagination').style.display = 'none';
            }

            // Update URL tanpa &search= jika input kosong
            history.replaceState(null, "", url);
        })
        .catch(error => {
            console.error('Error:', error); // Log error jika ada
        });
    }


</script>
@endsection
