@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Daftar Buku</h3>
    <a href="{{ route('buku.create') }}" class="btn btn-primary mb-3">Tambah Buku</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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
