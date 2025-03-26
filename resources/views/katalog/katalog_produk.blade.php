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

    @include('katalog.partial_produk')
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
                console.log("Searching for:", this.value);  // Menampilkan nilai pencarian
                fetchProduk();
            }, 500); // 500ms delay agar tidak langsung request saat user mengetik
        });

        function fetchProduk() {
            let perPage = document.getElementById('perPage').value;
            let search = document.getElementById('search').value.trim(); // Hilangkan spasi kosong
            let url = `/katalog?perPage=${perPage}`;

            if (search) {
                url += `&search=${encodeURIComponent(search)}`; // Tambahkan search jika ada input
            }

            console.log("Fetching URL:", url); // Log URL yang dikirim untuk debugging

            fetch(url, {
                headers: { "X-Requested-With": "XMLHttpRequest" } // Deteksi request AJAX
            })
            .then(response => response.text())
            .then(data => {
                console.log("Received Data:", data); // Log response dari server untuk debugging

                let parser = new DOMParser();
                let newDoc = parser.parseFromString(data, "text/html");

                // Perbarui konten tabel produk dan pagination
                let newContent = newDoc.querySelector('.row.row-cols-auto');
                let newPagination = newDoc.querySelector('.d-flex.flex-column.flex-md-row');

                // Update tampilan produk dan pagination
                document.querySelector('.row.row-cols-auto').innerHTML = newContent.innerHTML;
                document.querySelector('.d-flex.flex-column.flex-md-row').innerHTML = newPagination.innerHTML;

                // Update URL tanpa &search= jika input kosong
                history.replaceState(null, "", url);
            })
            .catch(error => {
                console.error('Error:', error); // Log error jika ada
            });
        }
    </script>
</div>

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('error') }}',
        });
    </script>
@endif
@endsection
