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
