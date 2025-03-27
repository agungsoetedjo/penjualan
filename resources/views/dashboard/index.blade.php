@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 fw-bold text-success">Dashboard</h2>

    <div class="row">
        <!-- Total Produk -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="background-color: #44a24c;">
                <div class="card-body text-white d-flex align-items-center">
                    <i class="bi bi-box-seam fs-1 me-3"></i>
                    <div>
                        <h5 class="card-title fw-bold" style="font-size: 1.1rem;">Total Produk</h5>
                        <h2 class="fw-bold" style="font-size: 2.5rem;">{{ $totalProduk }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Kategori -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="background-color: #87CEEB;">
                <div class="card-body text-success d-flex align-items-center">
                    <i class="bi bi-tags fs-1 me-3"></i>
                    <div>
                        <h5 class="card-title fw-bold" style="font-size: 1.1rem; color: #004B32;">Total Kategori</h5>
                        <h2 class="fw-bold" style="font-size: 2.5rem; color: #006400;">{{ $totalKategori }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Diagram Batang Vertikal -->
    <div class="card mt-4 border-0 shadow-sm">
        <div class="card-header fw-bold bg-success text-white">
            <i class="bi bi-bar-chart-line"></i> Rincian Produk per Kategori
        </div>
        <div class="card-body">
            @if(empty($kategoriLabels))
                <p class="text-center text-muted"><i class="bi bi-exclamation-circle"></i> Belum ada data kategori dan produk.</p>
            @else
                <canvas id="kategoriChart" style="height: 300px;"></canvas>
            @endif
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

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var kategoriLabels = @json($kategoriLabels);
        var kategoriCounts = @json($kategoriCounts);

        // Jika tidak ada data, gunakan data dummy agar tidak error
        if (kategoriLabels.length === 0) {
            kategoriLabels = ["Data Kosong"];
            kategoriCounts = [0];
        }

        var ctx = document.getElementById('kategoriChart');
        if (ctx) {
            new Chart(ctx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: kategoriLabels,
                    datasets: [{
                        label: 'Jumlah Produk',
                        data: kategoriCounts,
                        backgroundColor: '#00C853',
                        borderColor: '#008A4E',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    });
</script>
@endsection
