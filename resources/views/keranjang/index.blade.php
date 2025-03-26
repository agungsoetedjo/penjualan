@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<style>
button.btn-sm {
    min-width: 30px;
    padding: 0.2rem 0.5rem;
}

input.form-control {
    width: 50px;
    height: 30px;
}
</style>
<div class="container mt-4 aria-hidden="true">
    <h5 class="mb-4">Keranjang</h5>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
        });
    </script>
    @endif

    @if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('error') }}',
        });
    </script>
    @endif

    @if($keranjangItems->isEmpty())
        <div class="row">
            <div class="col-md-8">
                <div class="card p-3 shadow mb-3" style="border-radius: 8px;">
                    <div class="text-center">
                        <img src="{{ asset('assets/img/4d27af6a.svg') }}" alt="Keranjang Kosong" class="mb-3" style="max-width: 100px; height: auto;">
                        <h5 style="font-size: 1.2rem;">Keranjang Anda kosong</h5>
                        <p class="text-muted" style="font-size: 1rem;">Segera tambahkan produk ke keranjang Anda.</p>
                        <a href="/katalog" class="btn btn-success" style="font-size: 1rem; padding: 8px 16px; font-weight: bold;">Mulai Belanja</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3 mb-3 shadow" style="border-radius: 8px;">
                    <h5>Ringkasan belanja</h5>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Total</span>
                        <h5 class="fw-bold mb-0 text-end">-</h5>
                    </div>
                    <form action="{{ route('transaksi.checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100 mt-3" disabled>Checkout</button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-8">
                <div class="card p-3 mb-3" id="keranjangItems">
                    @include('keranjang.partial_keranjang', ['keranjang' => $keranjangItems])
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <h6 class="fw-bold">Ringkasan Belanja</h6>
                    <div class="d-flex justify-content-between">
                        <span>Total</span>
                        <span id="totalHarga" class="fw-bold">Rp{{ number_format($totalHarga, 0, ',', '.') }}</span>
                    </div>
                    <form action="{{ route('transaksi.checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100 mt-3" @if($keranjangItems->isEmpty()) disabled @endif>Checkout</button>
                    </form>

                </div>
            </div>
        </div>
    @endif
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).on('click', '.kurangi', function() {
    var productId = $(this).data('id');

    $.ajax({
        url: '/keranjang/kurangi/' + productId,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
        },
        success: function(response) {
            // Update keranjang and total price dynamically
            $('#keranjangItems').html(response.keranjang);  // Update list keranjang
            $('#totalHarga').text('Rp' + response.totalHarga);  // Update total price
        },
        error: function(response) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: response.responseJSON.error,
            });
        }
    });
});

$(document).on('click', '.tambah', function() {
    var productId = $(this).data('id');

    $.ajax({
        url: '/keranjang/tambah/' + productId,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
        },
        success: function(response) {
            // Update keranjang and total price dynamically
            $('#keranjangItems').html(response.keranjang);  // Update list keranjang
            $('#totalHarga').text('Rp' + response.totalHarga);  // Update total price
        },
        error: function(response) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: response.responseJSON.error,
            });
        }
    });
});


</script>
@endsection
