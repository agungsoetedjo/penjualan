@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 fw-bold text-success">Dashboard</h2>

    <div class="row">
        <!-- Total Produk -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3 bg-light">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-circle bg-success text-white me-3 p-3 rounded-circle">
                        <i class="bi bi-box-seam fs-2"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-muted">Total Produk</h5>
                        <p class="fs-2 fw-bold mb-0 text-dark">{{ $totalProduk }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Kategori -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3 bg-light">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-circle bg-success text-white me-3 p-3 rounded-circle">
                        <i class="bi bi-tags fs-2"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-muted">Total Kategori</h5>
                        <p class="fs-2 fw-bold mb-0 text-dark">{{ $totalKategori }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .icon-circle {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }

    .bg-light {
        background-color: #f8f9fa !important; /* Background soft */
    }

    .text-muted {
        color: #6c757d !important; /* Abu-abu soft */
    }

    .text-success {
        color: #00aa5b !important; /* Hijau khas Tokopedia */
    }

    .bg-success {
        background-color: #00aa5b !important; /* Hijau khas Tokopedia */
    }
</style>
@endsection
