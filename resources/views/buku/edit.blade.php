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
