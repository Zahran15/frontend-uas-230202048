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
            @foreach($peminjaman as $p)
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
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
