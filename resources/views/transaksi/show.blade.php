@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
<div class="container mt-4">
    <h3>Detail Transaksi</h3>

    <div class="card">
        <div class="card-body">
            <h5>Kode Transaksi: {{ $transaksi->kode_transaksi }}</h5>
            <p>Status: <span class="badge bg-warning">{{ $transaksi->status }}</span></p>
            <p>Total Harga: <strong>Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</strong></p>
        </div>
    </div>

    <h4 class="mt-4">Produk dalam Transaksi</h4>
    <ul class="list-group">
        @foreach($transaksi->details as $detail)
            <li class="list-group-item">
                {{ $detail->produk->nama }} - {{ $detail->jumlah }} x Rp{{ number_format($detail->produk->harga, 0, ',', '.') }} = Rp{{ number_format($detail->subtotal, 0, ',', '.') }}
            </li>
        @endforeach
    </ul>
</div>
@endsection
