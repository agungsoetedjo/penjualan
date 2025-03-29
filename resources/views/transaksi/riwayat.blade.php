@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="container mt-4">
    <h5>Riwayat Transaksi</h5>

    <form action="{{ route('transaksi.riwayat') }}" method="GET">
        <label>Status: </label>
        <select name="status" class="form-select d-inline w-auto" onchange="this.form.submit()">
            <option value="">Semua</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
        </select>
    </form>

    @foreach($transaksi as $trx)
    <div class="card mb-3">
        <div class="card-body">
            <h6>Kode Transaksi: <strong>{{ $trx->kode_transaksi }}</strong></h6>
            <p>Total: <strong>Rp{{ number_format($trx->total_harga, 0, ',', '.') }}</strong></p>
            <p>Status: <span class="badge bg-warning">{{ $trx->status }}</span></p>

            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#detail{{ $trx->id }}">Detail</button>

            @if(auth()->user()->role == 'admin')
            <form action="{{ route('transaksi.update-status', $trx->id) }}" method="POST" class="d-inline">
                @csrf
                <select name="status" class="form-select d-inline w-auto" onchange="this.form.submit()">
                    <option value="pending" {{ $trx->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="diproses" {{ $trx->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ $trx->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </form>
            @endif
        </div>
    </div>

    <!-- Modal Detail Transaksi -->
    <div class="modal fade" id="detail{{ $trx->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Detail Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @foreach($trx->details as $detail)
                        <p>{{ $detail->produk->nama }} - {{ $detail->jumlah }} x Rp{{ number_format($detail->produk->harga, 0, ',', '.') }}</p>
                    @endforeach
                    <hr>
                    <p><strong>Total: Rp{{ number_format($trx->total_harga, 0, ',', '.') }}</strong></p>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: '{{ session('success') }}',
        });
    </script>
@endif

@endsection
