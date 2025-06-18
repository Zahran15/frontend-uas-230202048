<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Aplikasi Buku| @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Tambahkan Bootstrap atau CSS lainnya jika perlu -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 1rem;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            flex-grow: 1;
            padding: 2rem;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h4 class="text-center mt-3">Dashboard</h4>
        <a href="{{ url('/buku') }}">Buku</a>
        <a href="{{ url('/peminjaman') }}">Peminjaman</a>
    </div>
    
    <div class="content">
        <nav class="navbar navbar-light bg-light mb-4">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1">@yield('title')</span>
            </div>
        </nav>
        
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
