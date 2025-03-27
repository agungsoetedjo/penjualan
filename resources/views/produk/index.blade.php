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
                        <img src="{{ asset($p->gambar) }}" alt="Gambar Produk" width="50">
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

                    <form action="{{ route('produk.destroy', $p->id) }}" method="POST" class="d-inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" data-id="{{ $p->id }}" class="btn btn-danger btn-sm delete-btn">
                            <i class="bi bi-trash"></i>
                        </button>
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
                                <!-- Input Nama Produk -->
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Nama Produk</span>
                                    <input type="text" name="nama" class="form-control" value="{{ $p->nama }}" required maxlength="255" aria-label="Nama Produk">
                                </div>

                                <!-- Input Harga -->
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Harga</span>
                                    <input type="number" name="harga" class="form-control" value="{{ $p->harga }}" required min="1" aria-label="Harga">
                                </div>

                                <!-- Input Stok -->
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Stok</span>
                                    <input type="number" name="stok" class="form-control" value="{{ $p->stok }}" required min="0" aria-label="Stok">
                                </div>

                                <!-- Input Kategori -->
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Kategori</span>
                                    <select name="kategori_id" class="form-control" required aria-label="Kategori">
                                        @foreach($kategori as $k)
                                            <option value="{{ $k->id }}" {{ $p->kategori_id == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Input Gambar Produk -->
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Gambar Produk</span>
                                    <input type="file" name="gambar" class="form-control gambar-input" data-preview="preview{{ $p->id }}" accept="image/*" aria-label="Gambar Produk">
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
                    <!-- Input Nama Produk -->
                    <div class="input-group mb-3">
                        <span class="input-group-text">Nama Produk</span>
                        <input type="text" name="nama" class="form-control" required maxlength="255" aria-label="Nama Produk">
                    </div>

                    <!-- Input Harga -->
                    <div class="input-group mb-3">
                        <span class="input-group-text">Harga</span>
                        <input type="number" name="harga" class="form-control" required min="1" aria-label="Harga">
                    </div>

                    <!-- Input Stok -->
                    <div class="input-group mb-3">
                        <span class="input-group-text">Stok</span>
                        <input type="number" name="stok" class="form-control" required min="0" aria-label="Stok">
                    </div>

                    <!-- Input Kategori -->
                    <div class="input-group mb-3">
                        <span class="input-group-text">Kategori</span>
                        <select name="kategori_id" class="form-control" required aria-label="Kategori">
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Input Gambar Produk -->
                    <div class="input-group mb-3">
                        <span class="input-group-text">Gambar Produk</span>
                        <input type="file" name="gambar" class="form-control gambar-input" required accept="image/*" aria-label="Gambar Produk">
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
});
    // Konfirmasi sebelum hapus produk
    $(document).on("click", ".delete-btn", function () {
        let form = $(this).closest(".delete-form");
        let produkId = $(this).data("id");

        console.log("Menghapus produk ID:", produkId); // Debugging

        Swal.fire({
            title: "Yakin ingin menghapus?",
            text: "Data tidak bisa dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, Hapus!"
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    $(document).ready(function () {
    // Reset form saat modal ditutup
    $('.modal').on('hidden.bs.modal', function () {
        // Reset form input
        let form = $(this).find('form')[0];
        if (form) form.reset(); // Reset input form

        // Reset input file gambar
        $(this).find('.gambar-input').each(function () {
            $(this).val(''); // Reset input file gambar
        });
    });

    // Pastikan modal tambah produk reset setelah ditutup
    $('#modalTambahProduk').on('hidden.bs.modal', function () {
        $(this).find('.gambar-input').val(''); // Reset input file gambar
    });

    // Pastikan modal edit produk reset setelah ditutup
    $('.modal').on('hidden.bs.modal', function () {
        let modalId = $(this).attr('id');
        if (modalId && modalId.startsWith('modalEditProduk')) {
            // Reset input file gambar untuk modal edit produk
            $(this).find('.gambar-input').val(''); // Reset input file gambar
        }
    });
});



</script>

@endsection
