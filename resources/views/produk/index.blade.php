@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
<div class="container mt-4">
    @if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: '{!! implode("<br>", $errors->all()) !!}',
        });
    </script>
    @endif
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: @json(session('success')),
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
                <th data-orderable="true">#</th>
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
                        <form action="/produk/{{ $p->id }}" method="POST" enctype="multipart/form-data" class="form-edit">
                            @csrf @method('PUT')
                            <div class="modal-body">
                                <label class="form-label">Nama Produk</label>
                                <input type="text" name="nama" class="form-control mb-2" value="{{ $p->nama }}" required maxlength="255">
                        
                                <label class="form-label">Harga</label>
                                <input type="number" name="harga" class="form-control mb-2" value="{{ $p->harga }}" required min="1">
                        
                                <label class="form-label">Stok</label>
                                <input type="number" name="stok" class="form-control mb-2" value="{{ $p->stok }}" required min="0">
                        
                                <label class="form-label">Kategori</label>
                                <select name="kategori_id" class="form-control mb-2" required>
                                    @foreach($kategori as $k)
                                        <option value="{{ $k->id }}" {{ $p->kategori_id == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                    @endforeach
                                </select>
                        
                                <label class="form-label">Gambar Produk</label>
                                <input type="file" name="gambar" class="form-control mb-2 gambar-input" data-preview="preview{{ $p->id }}" accept="image/*">
                                
                                <div class="mt-2">
                                    <img id="preview{{ $p->id }}" src="{{ asset('storage/' . $p->gambar) }}" alt="Gambar Produk" class="img-thumbnail" width="100">
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
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="nama" class="form-control" required maxlength="255">
            
                    <label class="form-label">Harga</label>
                    <input type="number" name="harga" class="form-control" required min="1">
            
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" required min="0">
            
                    <label class="form-label">Kategori</label>
                    <select name="kategori_id" class="form-control" required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->id }}">{{ $k->nama }}</option>
                        @endforeach
                    </select>
            
                    <label class="form-label">Gambar Produk</label>
                    <input type="file" name="gambar" class="form-control" required accept="image/*">
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
$(document).ready(function () {
    $('.datatable').DataTable();

    // Validasi sebelum submit form tambah & edit produk
    $('form').on('submit', function (event) {
        let nama = $(this).find("[name='nama']").val().trim();
        let harga = $(this).find("[name='harga']").val();
        let stok = $(this).find("[name='stok']").val();
        let kategori = $(this).find("[name='kategori_id']").val();

        if (nama === "" || harga === "" || stok === "" || kategori === "") {
            event.preventDefault();
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Semua kolom harus diisi!",
            });
        } else if (harga < 1 || stok < 0) {
            event.preventDefault();
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Harga minimal Rp1 dan stok tidak boleh negatif!",
            });
        }
    });

    // Konfirmasi sebelum hapus produk
    $('.delete-btn').on('click', function () {
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
                $(this).closest('.delete-form').submit();
            }
        });
    });

    // Preview gambar sebelum diupload
    $('.gambar-input').on('change', function () {
        let previewId = $(this).data('preview');
        let reader = new FileReader();
        reader.onload = function (e) {
            $('#' + previewId).attr('src', e.target.result);
        };
        reader.readAsDataURL(this.files[0]);
    });

    // Reset form setelah modal ditutup
    $('.modal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $(this).find('.img-thumbnail').attr('src', '');
    });
});

</script>

@endsection
