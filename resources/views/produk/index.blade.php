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

    <table class="table table-bordered table-striped datatable">
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
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditProduk{{ $p->id }}"><i class="bi bi-pencil"></i></button>

                    <form action="/produk/{{ $p->id }}" method="POST" class="d-inline delete-form">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm delete-btn"><i class="bi bi-trash"></i></button>
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
                                <!-- Nama Produk -->
                                <label for="nama{{ $p->id }}" class="form-label">Nama Produk</label>
                                <input type="text" id="nama{{ $p->id }}" name="nama" class="form-control mb-2" value="{{ $p->nama }}" required>
            
                                <!-- Harga Produk -->
                                <label for="harga{{ $p->id }}" class="form-label">Harga</label>
                                <input type="number" id="harga{{ $p->id }}" name="harga" class="form-control mb-2" value="{{ $p->harga }}" required>
            
                                <!-- Stok Produk -->
                                <label for="stok{{ $p->id }}" class="form-label">Stok</label>
                                <input type="number" id="stok{{ $p->id }}" name="stok" class="form-control mb-2" value="{{ $p->stok }}" required>
            
                                <!-- Kategori Produk -->
                                <label for="kategori{{ $p->id }}" class="form-label">Kategori</label>
                                <select id="kategori{{ $p->id }}" name="kategori_id" class="form-control mb-2">
                                    @foreach($kategori as $k)
                                        <option value="{{ $k->id }}" {{ $p->kategori_id == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                    @endforeach
                                </select>
            
                                <!-- Upload Gambar -->
                                <label for="gambar{{ $p->id }}" class="form-label">Gambar Produk</label>
                                <input type="file" id="gambar{{ $p->id }}" name="gambar" class="form-control mb-2">
                                
                                <!-- Preview Gambar -->
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $p->gambar) }}" alt="Gambar Produk" class="img-thumbnail" width="100">
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/ourscript.js') }}"></script>

<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            Swal.fire({
                title: "Yakin ingin menghapus?",
                text: "Data tidak bisa dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, Hapus!"
            }).then(result => {
                if (result.isConfirmed) {
                    this.closest('.delete-form').submit();
                }
            });
        });
    });

    $(document).ready(function () {
        $('#modalTambahProduk').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset(); // Reset form di dalam modal
        });
    });

    $(document).ready(function () {
        $('#modalEditProduk').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset(); // Reset form di dalam modal
        });
    });
</script>

@endsection
