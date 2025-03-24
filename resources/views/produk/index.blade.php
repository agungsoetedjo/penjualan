@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
<div class="container mt-4">
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
        });
    </script>
    @endif

    <h3>Daftar Produk</h3>

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahProduk">
        Tambah Produk
    </button>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produk as $key => $p)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>
                    @if($p->gambar)
                        <img src="{{ asset('storage/' . $p->gambar) }}" alt="Gambar Produk" width="50">
                    @else
                        <small class="text-muted">Tidak ada gambar</small>
                    @endif
                </td>
                <td>{{ $p->nama }}</td>
                <td>Rp{{ number_format($p->harga, 0, ',', '.') }}</td>
                <td>{{ $p->stok }}</td>
                <td>{{ $p->kategori->nama }}</td>
                <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditProduk{{ $p->id }}">Edit</button>

                    <form action="/produk/{{ $p->id }}" method="POST" class="d-inline delete-form">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm delete-btn">Hapus</button>
                    </form>
                </td>
            </tr>

            <!-- Modal Edit Produk -->
            <div class="modal fade" id="modalEditProduk{{ $p->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Produk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="/produk/{{ $p->id }}" method="POST" enctype="multipart/form-data">
                            @csrf @method('PUT')
                            <div class="modal-body">
                                <input type="text" name="nama" class="form-control mb-2" value="{{ $p->nama }}" required>
                                <input type="number" name="harga" class="form-control mb-2" value="{{ $p->harga }}" required>
                                <input type="number" name="stok" class="form-control mb-2" value="{{ $p->stok }}" required>
                                <select name="kategori_id" class="form-control mb-2">
                                    @foreach($kategori as $k)
                                        <option value="{{ $k->id }}" {{ $p->kategori_id == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                    @endforeach
                                </select>
                                <input type="file" name="gambar" class="form-control mb-2">
                                <img src="{{ asset('storage/' . $p->gambar) }}" alt="Gambar Produk" width="50">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah Produk -->
<div class="modal fade" id="modalTambahProduk" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/produk" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Harga</label>
                        <input type="number" name="harga" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Kategori</label>
                        <select name="kategori_id" class="form-control" required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Gambar Produk</label>
                        <input type="file" name="gambar" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            Swal.fire({ title: "Hapus?", icon: "warning", showCancelButton: true }).then(result => {
                if (result.isConfirmed) this.closest('.delete-form').submit();
            });
        });
    });
</script>

@endsection
