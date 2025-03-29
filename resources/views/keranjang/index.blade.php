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
                    <form action="{{ route('katalog.checkout') }}" method="POST">
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
                    <form action="{{ route('katalog.checkout') }}" method="POST">
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
$(document).ready(function() {
    $('.tambah, .kurangi').on('click', function() {
        let jumlahContainer = $(this).closest('.d-flex.align-items-center'); 
        let jumlahInput = jumlahContainer.find('.jumlah-input');
        let produk_id = $(this).data('id');
        let stokMaks = parseInt(jumlahInput.data('stok'));
        let jumlah = parseInt(jumlahInput.val());
        let errorSpan = $(this).closest('.d-flex.justify-content-end')
                             .next('.stokwarning')
                             .find('.error-stok'); // ✅ Fix pencarian error span

        if ($(this).hasClass('tambah')) {
            jumlah += 1;
        } else if ($(this).hasClass('kurangi') && jumlah > 1) {
            jumlah -= 1;
        }

        if (jumlah > stokMaks) {
            errorSpan.show().text(`Maks. beli ${stokMaks}`);
            jumlah = stokMaks;
        } else {
            errorSpan.hide();
        }

        jumlahInput.val(jumlah);
        updateKeranjang(produk_id, jumlah);
    });

    $('.jumlah-input').on('input', function() {
        let jumlahContainer = $(this).closest('.d-flex.align-items-center'); 
        let jumlahInput = $(this);
        let produk_id = jumlahContainer.find('.tambah').data('id');
        let stokMaks = parseInt(jumlahInput.data('stok'));
        let jumlah = parseInt(jumlahInput.val());
        let errorSpan = $(this).closest('.d-flex.justify-content-end')
                             .next('.stokwarning')
                             .find('.error-stok'); // ✅ Fix pencarian error span

        if (isNaN(jumlah) || jumlah < 1) {
            jumlah = 1;
        } else if (jumlah > stokMaks) {
            errorSpan.show().text(`Maks. beli ${stokMaks}`);
            jumlah = stokMaks;
        } else {
            errorSpan.hide();
        }

        jumlahInput.val(jumlah);
        updateKeranjang(produk_id, jumlah);
    });

    // Menyembunyikan notifikasi saat klik di luar input jumlah
    $(document).on('click', function(event) {
        if (!$(event.target).closest('.jumlah-input, .tambah, .kurangi').length) {
            $('.error-stok').fadeOut(); 
        }
    });
    
    function updateKeranjang(produk_id, jumlah) {
        let jumlahContainer = $('.jumlah-input[data-id="'+ produk_id +'"]').closest('.d-flex.align-items-center');
        let errorSpan = jumlahContainer.closest('.d-flex.justify-content-end')
                                       .next('.stokwarning')
                                       .find('.error-stok'); // ✅ Fix pencarian error span

        if (jumlah > parseInt(jumlahContainer.find('.jumlah-input').data('stok'))) {
            jumlah = parseInt(jumlahContainer.find('.jumlah-input').data('stok'));
            jumlahContainer.find('.jumlah-input').val(jumlah);
            errorSpan.show().text(`Maks. beli ${jumlah}`);
        } else {
            errorSpan.hide();
        }

        $.ajax({
            url: "{{ route('keranjang.update') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                produk_id: produk_id,
                jumlah: jumlah
            },
            success: function(response) {
                if (response.status === 'success') {
                    $('.jumlah-input[data-id="'+ produk_id +'"]').val(response.jumlah);
                    $('.subtotal[data-id="'+ produk_id +'"]').text("Rp" + response.subtotal);
                    $('#totalHarga').text("Rp" + response.total);
                }
            }
        });
    }
});
</script>

    
@endsection
