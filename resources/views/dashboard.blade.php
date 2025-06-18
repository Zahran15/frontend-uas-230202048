<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Aplikasi Buku | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            font-family: 'Segoe UI', sans-serif;
        }

        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: #fff;
            padding-top: 1rem;
        }

        .sidebar h4 {
            text-align: center;
            margin-bottom: 2rem;
            font-weight: 500;
        }

        .sidebar a {
            color: #fff;
            display: block;
            padding: 0.75rem 1.25rem;
            text-decoration: none;
            transition: 0.2s;
        }

        .sidebar a:hover {
            background-color: #495057;
            padding-left: 1.5rem;
        }

        .content {
            flex-grow: 1;
            padding: 2rem;
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h4>Dashboard</h4>
        <a href="{{ url('/buku') }}">Buku</a>
        <a href="{{ url('/peminjaman') }}">Peminjaman</a>
        <!-- Tambahkan link lainnya di sini jika perlu -->
    </div>

    <div class="content">
        <nav class="navbar mb-4">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1">@yield('title')</span>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
