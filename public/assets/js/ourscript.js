function initDataTable(selector) {
    $(selector).DataTable({
        "lengthMenu": [5, 10, 25, 50],
        "language": {
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "zeroRecords": "Data tidak ditemukan",
            "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            "infoEmpty": "Tidak ada data tersedia",
            "infoFiltered": "(disaring dari _MAX_ total data)",
            "search": "Cari:",
            "paginate": {
                "first": "Awal",
                "last": "Akhir",
                "next": "→",
                "previous": "←"
            }
        }
    });
}

// Panggil DataTable untuk tabel yang memiliki class "datatable"
$(document).ready(function() {
    $('.datatable').each(function() {
        initDataTable(this);
    });
});