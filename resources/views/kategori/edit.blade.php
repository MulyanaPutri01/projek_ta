@extends('layouts.app')

@section('content')
    <h1>Edit Kategori</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kategori.update', $kategori->id_kategori) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="id_kategori">ID Kategori:</label>
        <input type="text" name="id_kategori" id="id_kategori" value="{{ old('id_kategori', $kategori->id_kategori) }}" required maxlength="2">
        <br>
        <label for="nama_kategori">Nama Kategori:</label>
        <input type="text" name="nama_kategori" id="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required maxlength="15">
        <br>
        <button type="submit">Simpan</button>
    </form>
@endsection
