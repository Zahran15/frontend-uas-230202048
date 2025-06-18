

# Frontend UAS - Laravel (NIM: 230202048)

## Langkah Instalasi dan Implementasi

1. Buka terminal di laptop atau PC kamu.
2. Jalankan perintah berikut untuk membuat project Laravel:

   composer create-project --prefer-dist laravel/laravel frontend_uas_230202048

3. Setelah selesai, buka folder frontend_uas_230202048 di editor.

4. Tambahkan library PDF dengan perintah:

   composer require barryvdh/laravel-dompdf

5. Masuk ke folder:
   app/Http/Controllers

6. Buat satu file controller baru bernama PerpusController.php dengan isi sebagai berikut:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;

class PerpusController extends Controller
{
    // === Buku ===
    public function bukuIndex()
    {
        $response = Http::get('http://localhost:8080/buku');
        $buku = $response->json();
        return view('buku.index', compact('buku'));
    }

    public function bukuCreate()
    {
        return view('buku.create');
    }

    public function bukuStore(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:100',
            'pengarang' => 'required|string|max:50',
            'penerbit' => 'required|string|max:50',
            'tahun_terbit' => 'required|digits:4|integer',
        ]);

        $response = Http::asJson()->post('http://localhost:8080/buku', $request->all());

        if ($response->successful()) {
            return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
        }

        return back()->withErrors(['error' => 'Gagal menambahkan buku'])->withInput();
    }

    public function bukuEdit($id)
    {
        $response = Http::get("http://localhost:8080/buku/$id");

        if ($response->successful()) {
            $buku = $response->json();
            return view('buku.edit', compact('buku'));
        }

        return back()->with('error', 'Data buku tidak ditemukan.');
    }

    public function bukuUpdate(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:100',
            'pengarang' => 'required|string|max:50',
            'penerbit' => 'required|string|max:50',
            'tahun_terbit' => 'required|digits:4|integer',
        ]);

        $response = Http::put("http://localhost:8080/buku/$id", $request->all());

        if ($response->successful()) {
            return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui.');
        }

        return back()->withErrors(['error' => 'Gagal mengupdate buku'])->withInput();
    }

    public function bukuDestroy($id)
    {
        $response = Http::delete("http://localhost:8080/buku/$id");

        if ($response->successful()) {
            return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
        }

        return back()->with('error', 'Gagal menghapus buku.');
    }

    public function bukuExportPDF()
    {
        $response = Http::get('http://localhost:8080/buku');
        $data = $response->json();
        $pdf = Pdf::loadView('buku.export-pdf', ['data' => $data]);
        return $pdf->download('data_buku.pdf');
    }

    // === Peminjaman ===
    public function peminjamanIndex()
    {
        $response = Http::get('http://localhost:8080/peminjaman');
        $peminjaman = $response->json();
        return view('peminjaman.index', compact('peminjaman'));
    }

    public function peminjamanCreate()
    {
        return view('peminjaman.create');
    }

    public function peminjamanStore(Request $request)
    {
        $request->validate([
            'nama_peminjam' => 'required|string|max:100',
            'judul_buku' => 'required|string|max:100',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $response = Http::asJson()->post('http://localhost:8080/peminjaman', $request->all());

        if ($response->successful()) {
            return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil ditambahkan.');
        }

        return back()->withErrors(['error' => 'Gagal menambahkan data peminjaman'])->withInput();
    }

    public function peminjamanEdit($id)
    {
        $response = Http::get("http://localhost:8080/peminjaman/$id");

        if ($response->successful()) {
            $peminjaman = $response->json();
            return view('peminjaman.edit', compact('peminjaman'));
        }

        return back()->with('error', 'Data peminjaman tidak ditemukan.');
    }

    public function peminjamanUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_peminjam' => 'required|string|max:100',
            'judul_buku' => 'required|string|max:100',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $response = Http::put("http://localhost:8080/peminjaman/$id", $request->all());

        if ($response->successful()) {
            return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil diperbarui.');
        }

        return back()->withErrors(['error' => 'Gagal mengupdate data peminjaman'])->withInput();
    }

    public function peminjamanDestroy($id)
    {
        $response = Http::delete("http://localhost:8080/peminjaman/$id");

        if ($response->successful()) {
            return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil dihapus.');
        }

        return back()->with('error', 'Gagal menghapus data peminjaman.');
    }

    public function peminjamanExportSinglePDF($id)
    {
        $response = Http::get("http://localhost:8080/peminjaman/$id");

        if ($response->successful()) {
            $peminjaman = $response->json();
            $pdf = Pdf::loadView('peminjaman.export-pdf-single', ['peminjaman' => $peminjaman]);
            return $pdf->download("peminjaman_{$id}.pdf");
        }

        return back()->with('error', 'Data peminjaman tidak ditemukan.');
    }
}


Langkah ketiga:
Buka Folder resources\views dan buat 3 folder dan satu file:
Folder Buku:
create.blade.php:
@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Buku</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('buku.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" value="{{ old('judul') }}">
        </div>
        <div class="form-group mb-3">
            <label>Pengarang</label>
            <input type="text" name="pengarang" class="form-control" value="{{ old('pengarang') }}">
        </div>
        <div class="form-group mb-3">
            <label>Penerbit</label>
            <input type="text" name="penerbit" class="form-control" value="{{ old('penerbit') }}">
        </div>
        <div class="form-group mb-3">
            <label>Tahun Terbit</label>
            <input type="number" name="tahun_terbit" class="form-control" value="{{ old('tahun_terbit') }}">
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('buku.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection

edit.blade.php:
@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Buku</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('buku.update', $buku['id']) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" value="{{ old('judul', $buku['judul']) }}">
        </div>
        <div class="form-group mb-3">
            <label>Pengarang</label>
            <input type="text" name="pengarang" class="form-control" value="{{ old('pengarang', $buku['pengarang']) }}">
        </div>
        <div class="form-group mb-3">
            <label>Penerbit</label>
            <input type="text" name="penerbit" class="form-control" value="{{ old('penerbit', $buku['penerbit']) }}">
        </div>
        <div class="form-group mb-3">
            <label>Tahun Terbit</label>
            <input type="number" name="tahun_terbit" class="form-control" value="{{ old('tahun_terbit', $buku['tahun_terbit']) }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('buku.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

export-pdf.blade.php:
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Buku</title>
    <style>
        body {
            font-family: sans-serif;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
    </style>
</head>
<body>
    <h2>Daftar Buku</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Penerbit</th>
                <th>Tahun Terbit</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($data as $buku)
            <tr>
                <td>{{ $buku['id'] }}</td>
                <td>{{ $buku['judul'] }}</td>
                <td>{{ $buku['pengarang'] }}</td>
                <td>{{ $buku['penerbit'] }}</td>
                <td>{{ $buku['tahun_terbit'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>

index.blade.php:
@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Daftar Buku</h3>
    <a href="{{ route('buku.create') }}" class="btn btn-primary mb-3">Tambah Buku</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('buku.export.pdf') }}" class="btn btn-secondary mb-3">Export PDF</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Penerbit</th>
                <th>Tahun Terbit</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($buku as $b)
            <tr>
                <td>{{ $b['id'] }}</td>
                <td>{{ $b['judul'] }}</td>
                <td>{{ $b['pengarang'] }}</td>
                <td>{{ $b['penerbit'] }}</td>
                <td>{{ $b['tahun_terbit'] }}</td>
                <td>
                    <a href="{{ route('buku.edit', $b['id']) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('buku.destroy', $b['id']) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

Folder layouts
app.blade.php:
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

Folder peminjaman
create.blade.php:
@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Data Peminjaman</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('peminjaman.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label>Nama Peminjam</label>
            <input type="text" name="nama_peminjam" class="form-control" value="{{ old('nama_peminjam') }}">
        </div>
        <div class="form-group mb-3">
            <label>Judul Buku</label>
            <input type="text" name="judul_buku" class="form-control" value="{{ old('judul_buku') }}">
        </div>
        <div class="form-group mb-3">
            <label>Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" class="form-control" value="{{ old('tanggal_pinjam') }}">
        </div>
        <div class="form-group mb-3">
            <label>Tanggal Kembali</label>
            <input type="date" name="tanggal_kembali" class="form-control" value="{{ old('tanggal_kembali') }}">
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection

edit.blade.php:
@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Data Peminjaman</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('peminjaman.update', $peminjaman['id']) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label>Nama Peminjam</label>
            <input type="text" name="nama_peminjam" class="form-control" value="{{ old('nama_peminjam', $peminjaman['nama_peminjam']) }}">
        </div>
        <div class="form-group mb-3">
            <label>Judul Buku</label>
            <input type="text" name="judul_buku" class="form-control" value="{{ old('judul_buku', $peminjaman['judul_buku']) }}">
        </div>
        <div class="form-group mb-3">
            <label>Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" class="form-control" value="{{ old('tanggal_pinjam', $peminjaman['tanggal_pinjam']) }}">
        </div>
        <div class="form-group mb-3">
            <label>Tanggal Kembali</label>
            <input type="date" name="tanggal_kembali" class="form-control" value="{{ old('tanggal_kembali', $peminjaman['tanggal_kembali']) }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

export-pdf-single.blade.php:
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Peminjaman</title>
    <style>
        body {
            font-family: sans-serif;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        td {
            border: 1px solid #000;
            padding: 8px;
        }
        .label {
            background-color: #eee;
            font-weight: bold;
            width: 30%;
        }
    </style>
</head>
<body>
    <h2>Detail Peminjaman</h2>
    <table>
        <tr>
            <td class="label">ID</td>
            <td>{{ $peminjaman['id'] }}</td>
        </tr>
        <tr>
            <td class="label">Nama Peminjam</td>
            <td>{{ $peminjaman['nama_peminjam'] }}</td>
        </tr>
        <tr>
            <td class="label">Judul Buku</td>
            <td>{{ $peminjaman['judul_buku'] }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Pinjam</td>
            <td>{{ $peminjaman['tanggal_pinjam'] }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Kembali</td>
            <td>{{ $peminjaman['tanggal_kembali'] }}</td>
        </tr>
    </table>
</body>
</html>

index.blade.php:
@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Daftar Peminjaman</h3>

    <a href="{{ route('peminjaman.create') }}" class="btn btn-primary mb-3">Tambah Peminjaman</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Peminjam</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($peminjaman as $p)
                <tr>
                    <td>{{ $p['id'] }}</td>
                    <td>{{ $p['nama_peminjam'] }}</td>
                    <td>{{ $p['judul_buku'] }}</td>
                    <td>{{ $p['tanggal_pinjam'] }}</td>
                    <td>{{ $p['tanggal_kembali'] }}</td>
                    <td>
                        <a href="{{ route('peminjaman.edit', $p['id']) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('peminjaman.destroy', $p['id']) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                        </form>
                        <a href="{{ route('peminjaman.export.single', $p['id']) }}" class="btn btn-sm btn-info">Export PDF</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

file dashboard.blade.php:
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
    </div>

    <div class="content">
        <nav class="navbar mb-4">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1">@yield('title')</span>
            </div>
        </nav>

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

Langkah keempat:
tes dengan php artisan serve dan backend nya dengan php spark serve 
apakah berjalan atau tidak

catatan:
jangan lupa membuat database di phpmyadmin terlebih dahulu


-- Langkah 1: Masuk ke phpMyAdmin

-- Langkah 2: Buat database
CREATE DATABASE db_perpus_12345678; -- Ganti 12345678 dengan NIM Anda
USE db_perpus_12345678;

-- Langkah 3: Buat tabel buku
CREATE TABLE buku (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(100) NOT NULL,
    pengarang VARCHAR(100) NOT NULL,
    penerbit VARCHAR(100) NOT NULL,
    tahun_terbit INT NOT NULL
);

-- Langkah 4: Buat tabel peminjaman
CREATE TABLE peminjaman (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_peminjam VARCHAR(100) NOT NULL,
    judul_buku VARCHAR(100) NOT NULL,
    tanggal_pinjam DATE NOT NULL,
    tanggal_kembali DATE NOT NULL
);
