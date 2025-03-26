<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Beranda')</title>
    <link rel="icon" href="https://laravel.com/img/logomark.min.svg" type="image/svg+xml">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.7/dist/sweetalert2.all.min.js"></script>
</head>
<style>
html, body {
    height: 100%;
    padding-top: 30px;
    margin: 0;
    display: flex;
    flex-direction: column;
}

.content {
    flex: 1;
}

footer {
    background: #222;
    color: white;
    text-align: center;
    padding: 10px 0;
}

</style>
<body>