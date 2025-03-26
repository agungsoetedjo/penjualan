@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container mt-4">
    <h2>Checkout</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($keranjang as $item)
            <tr>
                <td>{{ $item->produk->nama }}</td>
                <td>Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>Rp {{ number_format($item->jumlah * $item->produk->harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <h4>Total: Rp {{ number_format($keranjang->sum(fn($item) => $item->produk->harga * $item->jumlah), 0, ',', '.') }}</h4>
    <form action="/checkout" method="POST">
        @csrf
        <button type="submit" class="btn btn-success">Proses Checkout</button>
    </form>
</div>
@endsection
