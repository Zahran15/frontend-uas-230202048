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
